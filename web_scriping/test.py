import requests
from bs4 import BeautifulSoup
import mysql.connector
import re
from math import ceil
import smtplib
from email.mime.text import MIMEText
import logging
import traceback

# Set up logging
logging.basicConfig(filename='web_scriping/scraping.log', level=logging.ERROR)

# Function to send email notification
def send_email_notification(subject, message):
    sender_email = "yousefmyiu@gmail.com"
    receiver_email = "yousefmyou@gmail.com"
    password = "tapw tgor jeyt boic"

    msg = MIMEText(message)
    msg['Subject'] = subject
    msg['From'] = sender_email
    msg['To'] = receiver_email
    try:
        with smtplib.SMTP_SSL('smtp.gmail.com', 465) as server:
            server.login(sender_email, password)
            server.send_message(msg)
        logging.info("Email sent successfully!")
    except Exception as e:
        logging.error(f"Failed to send email: {e}")

# Context manager for MySQL database connection
class DatabaseConnection:
    def __init__(self):
        self.connection = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="root",
            database="bookstore"
        )
        self.cursor = self.connection.cursor()

    def __enter__(self):
        return self.cursor

    def __exit__(self, exc_type, exc_val, exc_tb):
        self.connection.commit()
        self.cursor.close()
        self.connection.close()

# Function to insert book information into the database
def insert_book_info(cursor, title, picture, author, genres, status, release_date, rating, tags, synopsis):
    insert_query = "INSERT INTO books (title, img, author, genres, status, release_date, sum_ratings, tags, Synopsis) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)"
    book_data = (title, picture, author, genres, status, release_date, rating, tags, synopsis )  # Providing a default value of 0
    cursor.execute(insert_query, book_data)

# Function to update book information in the database
def update_book_info(cursor, title, tags, status, release_date):
    update_query = "UPDATE books SET tags = %s, status = %s, release_date = %s  WHERE title = %s"
    update_data = (tags, status, release_date, title)  # Providing a default value of 0
    cursor.execute(update_query, update_data)

# Function to check if a book with the given title exists
def book_exists(cursor, title):
    select_query = "SELECT id FROM books WHERE title = %s"
    cursor.execute(select_query, (title,))
    return cursor.fetchone() is not None

# Function to insert chapter information into the database
def insert_chapter_info(cursor, book_id, chapter_name, chapter_text):
    insert_query = "INSERT INTO chapters (book_id, chapter_title, chapter_text) VALUES (%s, %s, %s)"
    chapter_data = (book_id, chapter_name, chapter_text)
    cursor.execute(insert_query, chapter_data)

# Function to check if a chapter with the given title exists
def chapter_exists(cursor, book_id, chapter_name):
    select_query = "SELECT id FROM chapters WHERE book_id = %s AND chapter_title = %s"
    cursor.execute(select_query, (book_id, chapter_name))
    return cursor.fetchone() is not None

# Select book id
def select_book_id(cursor, title):
    select_query = "SELECT id FROM books WHERE title = %s"
    cursor.execute(select_query, (title,))
    return cursor.fetchone()[0]

# Extract book information
def get_page_info(cursor, soup):
    try:
        for book_div in soup.find_all("div", class_="row c-tabs-item__content"):
            
            title__element = book_div.find("h3", class_="h4")
            title= title__element.text.strip() if title__element else "Null"

            base_url = book_div.find("a")["href"]

            picture__element = book_div.find("img")["data-src"]
            picture = picture__element if picture__element else "Null"

            author_element = book_div.find("div", class_="summary-content")
            author = author_element.text.strip() if author_element else "Null"

            genres_element = book_div.find('div', class_='mg_genres').find('div', class_='summary-content')
            genres = genres_element.text.strip() if genres_element else "Null"

            status_element = book_div.find('div', class_='mg_status').find('div', class_='summary-content')
            status = status_element.text.strip() if status_element else "Null"

            rating_element = book_div.find("span", class_="score font-meta total_votes")
            rating = rating_element.text.strip() if rating_element else "Null"

            release_date_element = book_div.find("div", class_="meta-item post-on")
            release_date = release_date_element.text.strip() if release_date_element else "Null"

            response = requests.get(base_url)
            tags_soup = BeautifulSoup(response.content, "html.parser")  

            tags_element = tags_soup.find("div", class_="tags-content")
            tags= tags_element.text.strip() if tags_element else "Null"

            Synopsis_element = tags_soup.find("div", class_="g_txt_over")
            Synopsis = Synopsis_element.prettify() if Synopsis_element else "Null"

            with DatabaseConnection() as db_cursor:

                if not book_exists(db_cursor, title):
                    # Insert book information into the database
                    insert_book_info(db_cursor, title, picture, author, genres, status, release_date, rating, tags, Synopsis)
                else:
                    # Update book information in the database
                    update_book_info(db_cursor, title, tags, status, release_date)

                # extract the number of chapters from the 'no_OF_chapters'
                no_OF_chapters = book_div.find("span", class_="font-meta chapter").text.strip()
                no_OF_chapters = re.search(r'\d+', no_OF_chapters)
                no_OF_chapters = int(no_OF_chapters.group())

                book_id = select_book_id(db_cursor, title)

                # Get the current number of chapters in the database for this book
                select_query = "SELECT COUNT(*) FROM chapters WHERE book_id = %s"
                db_cursor.execute(select_query, (book_id,))
                current_chapters_count = db_cursor.fetchone()[0]

                for chapter_number in range(current_chapters_count + 1, no_OF_chapters + 1):
                    try:
                        chapter_url = f"{base_url}chapter-{chapter_number}/"
                        response = requests.get(chapter_url)
                        response.raise_for_status()  # Raise an error for bad responses
                        soup = BeautifulSoup(response.content, "html.parser")

                        # Extract chapter information
                        chapter_name = soup.find("li", class_="active").text.strip()
                        chapter_text = soup.find("div", class_="text-left").prettify()

                        if book_id:
                            # Insert chapter information into the database
                            insert_chapter_info(db_cursor, book_id, chapter_name, chapter_text)

                    except requests.exceptions.RequestException as err:
                        logging.error(f"Error: {err}")
                        continue

    except Exception as e:
        logging.error(f"Error in processing book_div: {e}")


# Main scraping function
def scrape_boxnovel():
    try:
        base_url = "https://boxnovel.com/?s&post_type=wp-manga"
        response = requests.get(base_url)
        soup = BeautifulSoup(response.content, "html.parser")

        get_page_info(None, soup)  # Pass None for cursor as it's not needed here
        no_OF_page = soup.find("h1", class_="h4").text.strip()
        no_OF_page = re.search(r'\d+', no_OF_page)
        no_OF_page = ceil(int(no_OF_page.group()) / 10)

        for page_number in range(2, no_OF_page + 1):
            page_url = f"https://boxnovel.com/page/{page_number}/?s&post_type=wp-manga"
            response = requests.get(page_url)
            if response.status_code == 200:
                print(page_url)
                soup = BeautifulSoup(response.content, "html.parser")
                get_page_info(None, soup)  # Pass None for cursor as it's not needed here

        logging.info("Script execution completed successfully!")
    except Exception as e:
        error_message = f"An error occurred in scrape_boxnovel function: {e}\n\n{traceback.format_exc()}"
        logging.error(error_message)
        send_email_notification("Error in scraping script", error_message)


# Call the main scraping function
scrape_boxnovel()
