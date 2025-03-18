import csv
import requests
from bs4 import BeautifulSoup


file = open('ljobs.csv', 'a')
writer = csv.writer(file)
writer.writerow(['Title', 'Company', 'Location', 'Apply'])

def linkedin_scraper(webpage, page_number):
    next_page = webpage + str(page_number)
    print(str(next_page))
    response = requests.get(str(next_page))
    soup = BeautifulSoup(response.content, 'html.parser')
    

    jobs = soup.find_all('div', class_='base-card relative w-full hover:no-underline focus:no-underline base-card--link base-search-card base-search-card--link job-search-card')
    
    for job in jobs:
        job_title = job.find('h3', class_='base-search-card__title')
        job_title = job_title.text.strip() if job_title else 'N/A'

        job_company = job.find('h4', class_='base-search-card__subtitle')
        job_company = job_company.text.strip() if job_company else 'N/A'

        job_location = job.find('span', class_='job-search-card__location')
        job_location = job_location.text.strip() if job_location else 'N/A'

        job_link = job.find('a', class_='base-card__full-link')
        job_link = job_link['href'] if job_link else 'N/A'
        
        writer.writerow([
            job_title.encode('utf-8'),
            job_company.encode('utf-8'),
            job_location.encode('utf-8'),
            job_link.encode('utf-8')
        ])
    
    print('Data updated')
    
    if page_number <= 30:
        page_number += 1
        linkedin_scraper(webpage, page_number)
    else:
        file.close()
        print('File closed')

linkedin_scraper('https://www.linkedin.com/jobs-guest/jobs/api/seeMoreJobPostings/search?keywords=location=Pune&geoId=114806696&trk=public_jobs_jobs-search-bar_search-submit&position=1&pageNum=0&start=', 0)