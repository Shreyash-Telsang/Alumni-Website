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

# Function to create the Hackathons table
def create_hackathons_table(connection):
    try:
        cursor = connection.cursor()

        # Create table query
        create_table_query = """
        CREATE TABLE IF NOT EXISTS hackathons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            event_category VARCHAR(255),
            organizer VARCHAR(255),
            event_name VARCHAR(255),
            start_date DATE,
            end_date DATE,
            registration_deadline DATE,
            location VARCHAR(255),
            registration_link TEXT,
            mode VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        """

        cursor.execute(create_table_query)
        connection.commit()
        print("Table 'hackathons' created successfully in alumni_edi database")

    except Error as e:
        print(f"Error creating table: {e}")

# Function to import hackathons data into the database
def import_hackathons_data(file_path):
    connection = None
    try:
        # Read CSV file
        df = pd.read_csv(file_path)

        # Print the columns to debug the actual column names
        print("Columns in CSV:", df.columns)

        # Strip leading/trailing spaces from column names
        df.columns = df.columns.str.strip()

        # Clean the data by removing 'b' prefix and single quotes
        df['Event Categry'] = df['Event Categry'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Organizer'] = df['Organizer'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Event Name'] = df['Event Name'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Location'] = df['Location'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Registration link'] = df['Registration link'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Mode'] = df['Mode'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)

        # Convert date columns to proper date format if needed
        df['Start Date'] = pd.to_datetime(df['Start Date'], errors='coerce').dt.date
        df['End Date'] = pd.to_datetime(df['End Date'], errors='coerce').dt.date
        df['Registration deadline'] = pd.to_datetime(df['Registration deadline'], errors='coerce').dt.date

        # Create database connection
        connection = create_database_connection()

        if connection is not None:
            # Create table if it doesn't exist
            create_hackathons_table(connection)

            # Insert data
            cursor = connection.cursor()

            # Clear existing data if needed
            cursor.execute("TRUNCATE TABLE hackathons")

            # Insert rows from DataFrame
            for _, row in df.iterrows():
                insert_query = """
                INSERT INTO hackathons (event_category, organizer, event_name, start_date, end_date, registration_deadline, location, registration_link, mode)
                VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
                """
                values = (row['Event Categry'], row['Organizer'], row['Event Name'], row['Start Date'], row['End Date'], row['Registration deadline'], row['Location'], row['Registration link'], row['Mode'])

                cursor.execute(insert_query, values)

            connection.commit()
            print(f"Successfully imported {len(df)} hackathons into alumni_edi.hackathons table")

    except Error as e:
        print(f"Error importing data: {e}")
    except Exception as e:
        print(f"Error: {e}")
    finally:
        if connection and connection.is_connected():
            connection.close()
            print("Database connection closed.")

# Usage example
import_hackathons_data('Hackathons.csv')
