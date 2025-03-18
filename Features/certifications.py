import mysql.connector
from mysql.connector import Error
import pandas as pd

# Function to create a database connection
def create_database_connection():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",  # XAMPP default has no password
            database="alumni_edi",  # Your existing database
            port=3306  # Default XAMPP MySQL port
        )
        if connection.is_connected():
            print("Successfully connected to alumni_edi database")
        return connection
    except Error as e:
        print(f"Error connecting to MySQL Database: {e}")
        return None

# Function to create the Certifications table
def create_certifications_table(connection):
    try:
        cursor = connection.cursor()

        # Create table query
        create_table_query = """
        CREATE TABLE IF NOT EXISTS certifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            organizer VARCHAR(255),
            event_name VARCHAR(255),
            starting_date DATE,
            lecture_by VARCHAR(255),
            registration_link TEXT,
            mode VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        """

        cursor.execute(create_table_query)
        connection.commit()
        print("Table 'certifications' created successfully in alumni_edi database")

    except Error as e:
        print(f"Error creating table: {e}")

# Function to import certification data into the database
def import_certifications_data(file_path):
    connection = None
    try:
        # Read CSV file
        df = pd.read_csv(file_path)

        # Print the columns to debug the actual column names
        print("Columns in CSV:", df.columns)

        # Strip leading/trailing spaces from column names
        df.columns = df.columns.str.strip()

        # Clean the data by removing 'b' prefix and single quotes
        df['Organizer'] = df['Organizer'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['EventName'] = df['EventName'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Lectureby'] = df['Lectureby'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Registration link'] = df['Registration link'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Mode'] = df['Mode'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)

        # Convert date column to proper date format if needed
        df['Starting date'] = pd.to_datetime(df['Starting date'], errors='coerce').dt.date

        # Create database connection
        connection = create_database_connection()

        if connection is not None:
            # Create table if it doesn't exist
            create_certifications_table(connection)

            # Insert data
            cursor = connection.cursor()

            # Clear existing data if needed
            cursor.execute("TRUNCATE TABLE certifications")

            # Insert rows from DataFrame
            for _, row in df.iterrows():
                insert_query = """
                INSERT INTO certifications (organizer, event_name, starting_date, lecture_by, registration_link, mode)
                VALUES (%s, %s, %s, %s, %s, %s)
                """
                values = (row['Organizer'], row['EventName'], row['Starting date'], row['Lectureby'], row['Registration link'], row['Mode'])

                cursor.execute(insert_query, values)

            connection.commit()
            print(f"Successfully imported {len(df)} certifications into alumni_edi.certifications table")

    except Error as e:
        print(f"Error importing data: {e}")
    except Exception as e:
        print(f"Error: {e}")
    finally:
        if connection and connection.is_connected():
            connection.close()
            print("Database connection closed.")

# Usage example
import_certifications_data('Certifications.csv')
