# Gunakan image Python
FROM python:3.10-slim

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    build-essential \
    libglib2.0-0 \
    libsm6 \
    libxext6 \
    libxrender-dev \
    libgl1-mesa-glx \
    && rm -rf /var/lib/apt/lists/*

# Buat working directory
WORKDIR /app

# Salin file
COPY . .

# Install requirements
RUN pip install --no-cache-dir -r requirements.txt

# Expose port
EXPOSE 7860

# Jalankan app
CMD ["python", "app.py"]
