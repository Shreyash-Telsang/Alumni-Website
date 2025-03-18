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

# Function to create the LinkedIn jobs table
def create_linkedin_jobs_table(connection):
    try:
        cursor = connection.cursor()

        # Create table query
        create_table_query = """
        CREATE TABLE IF NOT EXISTS linkedinjob (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255),
            company VARCHAR(100),
            location VARCHAR(100),
            apply_link TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        """

        cursor.execute(create_table_query)
        connection.commit()
        print("Table 'linkedinjob' created successfully in alumni_edi database")

    except Error as e:
        print(f"Error creating table: {e}")

# Function to import jobs data into the database
def import_jobs_data(file_path):
    try:
        # Read CSV file
        df = pd.read_csv(file_path)

        # Clean the data by removing 'b' prefix and single quotes
        df['Title'] = df['Title'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Company'] = df['Company'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Location'] = df['Location'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)
        df['Apply'] = df['Apply'].str.replace(r"b'", '', regex=True).str.replace(r"'", '', regex=True)

        # Create database connection
        connection = create_database_connection()

        if connection is not None:
            # Create table if it doesn't exist
            create_linkedin_jobs_table(connection)

            # Insert data
            cursor = connection.cursor()

            # Clear existing data if needed
            cursor.execute("TRUNCATE TABLE linkedinjob")

            # Insert rows from DataFrame
            for _, row in df.iterrows():
                insert_query = """
                INSERT INTO linkedinjob (title, company, location, apply_link)
                VALUES (%s, %s, %s, %s)
                """
                values = (row['Title'], row['Company'], row['Location'], row['Apply'])

                cursor.execute(insert_query, values)

            connection.commit()
            print(f"Successfully imported {len(df)} jobs into alumni_edi.linkedinjob table")

    except Error as e:
        print(f"Error importing data: {e}")
    except Exception as e:
        print(f"Error: {e}")
    finally:
        if connection.is_connected():
            connection.close()
            print("Database connection closed.")

# Usage example
import_jobs_data('jobs.csv')
