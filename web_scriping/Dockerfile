FROM python:3.9

RUN pip install --no-cache-dir --upgrade pip setuptools

WORKDIR /app

RUN apt-get update && apt-get install -y default-mysql-client 

RUN pip install beautifulsoup4 && pip install mysql-connector-python &&  pip install requests 

COPY box.py .

CMD ["python", "box.py"]
