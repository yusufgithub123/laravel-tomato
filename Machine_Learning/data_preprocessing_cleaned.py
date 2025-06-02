from google.colab import files
import pandas as pd
import os
import shutil
import numpy as np
from PIL import Image
from collections import Counter
from tqdm.notebook import tqdm as tq
import cv2
import random
import matplotlib.pyplot as plt
import matplotlib.image as mpimg
import pathlib
import cv2
import albumentations as A
import numpy as np

from google.colab import files
files.upload()

# Download kaggle dataset and unzip the file
!mkdir -p ~/.kaggle
!cp kaggle.json ~/.kaggle/
!chmod 600 ~/.kaggle/kaggle.json

!kaggle datasets download ashishmotwani/tomato

!unzip tomato.zip

!mkdir original_data
!mkdir combine_data
!mkdir augmented_data

# Path ke folder dataset asli
train_dir = 'train'
val_dir = 'valid'

# Folder hasil penggabungan
original_data_dir = 'original_data'
os.makedirs(original_data_dir, exist_ok=True)

# Fungsi untuk menggabungkan data dari folder sumber ke folder tujuan
def merge_data(source_dir, destination_dir):
    for class_name in os.listdir(source_dir):
        class_dir = os.path.join(source_dir, class_name)
        if os.path.isdir(class_dir):
            destination_class_dir = os.path.join(destination_dir, class_name)
            os.makedirs(destination_class_dir, exist_ok=True)
            for filename in os.listdir(class_dir):
                src_file = os.path.join(class_dir, filename)

                # Hindari overwrite jika nama file sama
                dst_file = os.path.join(destination_class_dir, filename)
                if os.path.exists(dst_file):
                    name, ext = os.path.splitext(filename)
                    i = 1
                    while os.path.exists(os.path.join(destination_class_dir, f"{name}_{i}{ext}")):
                        i += 1
                    dst_file = os.path.join(destination_class_dir, f"{name}_{i}{ext}")

                shutil.copy(src_file, dst_file)

# Gabungkan data train dan test ke dalam original_data
merge_data(train_dir, original_data_dir)
merge_data(val_dir,original_data_dir)

print("Data telah digabungkan ke dalam folder 'original_data'.")


def visualize_images(base_dir):
    """Menampilkan satu gambar per label dari direktori tertentu."""

    plt.figure(figsize=(15, 15))

    for i, label in enumerate(os.listdir(base_dir)):
        label_dir = os.path.join(base_dir, label)
        if os.path.isdir(label_dir):
            image_files = [f for f in os.listdir(label_dir) if os.path.isfile(os.path.join(label_dir, f))]
            if image_files:
                random_image = random.choice(image_files)
                image_path = os.path.join(label_dir, random_image)
                image = plt.imread(image_path)

                plt.subplot(6, 6, i + 1)
                plt.imshow(image)
                plt.title(label)
                plt.axis('off')

    plt.tight_layout()
    plt.show()

# Contoh visualisasi gambar dari folder training
visualize_images('original_data')

def plot_class_distribution(dataset_dir):
    """Menampilkan grafik distribusi jumlah gambar per kelas."""
    class_counts = {}

    for class_name in os.listdir(dataset_dir):
        class_dir = os.path.join(dataset_dir, class_name)
        if os.path.isdir(class_dir):
            num_images = len([
                f for f in os.listdir(class_dir)
                if os.path.isfile(os.path.join(class_dir, f))
            ])
            class_counts[class_name] = num_images

    # Plotting
    plt.figure(figsize=(10, 6))
    plt.bar(class_counts.keys(), class_counts.values(), color='skyblue')
    plt.title('Distribusi Gambar per Kelas di original_data')
    plt.xlabel('Kelas')
    plt.ylabel('Jumlah Gambar')
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.show()

# Tampilkan grafik
plot_class_distribution('original_data')

# Path ke dataset asli (tiap kelas di dalam subfolder)
input_base_dir = 'original_data'
output_base_dir = 'augmented_data'

# Mapping kelas dan jumlah gambar tambahan yang diinginkan
augment_target = {
    'powdery_mildew': 2650,
    'Tomato_mosaic_virus': 1150,
    'Late_blight':0,
    'healthy':0,
    'Leaf_Mold': 400,
    'Tomato_Yellow_Leaf_Curl_Virus': 1300,
    'Bacterial_spot': 300,
    'Spider_mites Two-spotted_spider_mite': 1700,
    'Target_Spot': 1600,
    'Early_blight': 800,
    'Septoria_leaf_spot': 250
}

# Transformasi kombinasi augmentasi
transform = A.Compose([
    A.Rotate(limit=20, p=0.7),
    A.HorizontalFlip(p=0.5),
    A.VerticalFlip(p=0.3),
    A.RandomBrightnessContrast(p=0.5),
    A.ZoomBlur(p=0.2),  # FIXED: tidak lagi pakai zoom_limit
    A.ShiftScaleRotate(shift_limit=0.1, scale_limit=0.1, rotate_limit=0, p=0.5)
])

# Buat output folder jika belum ada
os.makedirs(output_base_dir, exist_ok=True)

# Proses setiap kelas
for class_name, target_aug_count in augment_target.items():
    input_class_dir = os.path.join(input_base_dir, class_name)
    output_class_dir = os.path.join(output_base_dir, class_name)
    os.makedirs(output_class_dir, exist_ok=True)

    image_files = [f for f in os.listdir(input_class_dir) if f.lower().endswith(('.jpg', '.jpeg', '.png'))]
    num_original = len(image_files)

    if num_original == 0:
        print(f"Skipping {class_name} because no original images were found.")
        continue

    # Hitung berapa augmentasi per gambar asli yang perlu dibuat
    aug_per_image = target_aug_count // num_original + 1

    pbar = tq(total=target_aug_count, desc=f'Augmenting {class_name}')
    total_augmented = 0

    for img_file in image_files:
        if total_augmented >= target_aug_count:
            break

        img_path = os.path.join(input_class_dir, img_file)
        image = cv2.imread(img_path)
        if image is None:
            print(f"Warning: Failed to read {img_path}")
            continue
        image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)

        for i in range(aug_per_image):
            if total_augmented >= target_aug_count:
                break
            augmented = transform(image=image)
            aug_image = augmented['image']

            aug_filename = f"{os.path.splitext(img_file)[0]}_aug{total_augmented}.jpg"
            save_path = os.path.join(output_class_dir, aug_filename)
            cv2.imwrite(save_path, cv2.cvtColor(aug_image, cv2.COLOR_RGB2BGR))
            total_augmented += 1
            pbar.update(1)

    pbar.close()


# Path ke folder dataset asli
original_data = 'original_data'
augmented_data = 'augmented_data'

# Folder hasil penggabungan
original_data_dir = 'combine_data'
os.makedirs(original_data_dir, exist_ok=True)

# Fungsi untuk menggabungkan data dari folder sumber ke folder tujuan
def merge_data(source_dir, destination_dir):
    for class_name in os.listdir(source_dir):
        class_dir = os.path.join(source_dir, class_name)
        if os.path.isdir(class_dir):
            destination_class_dir = os.path.join(destination_dir, class_name)
            os.makedirs(destination_class_dir, exist_ok=True)
            for filename in os.listdir(class_dir):
                src_file = os.path.join(class_dir, filename)

                # Hindari overwrite jika nama file sama
                dst_file = os.path.join(destination_class_dir, filename)
                if os.path.exists(dst_file):
                    name, ext = os.path.splitext(filename)
                    i = 1
                    while os.path.exists(os.path.join(destination_class_dir, f"{name}_{i}{ext}")):
                        i += 1
                    dst_file = os.path.join(destination_class_dir, f"{name}_{i}{ext}")

                shutil.copy(src_file, dst_file)

# Gabungkan data train dan test ke dalam combine_data
merge_data(original_data, original_data_dir)
merge_data(augmented_data,original_data_dir)

print("Data telah digabungkan ke dalam folder 'combine_data'.")


def plot_class_distribution(dataset_dir):
    """Menampilkan grafik distribusi jumlah gambar per kelas."""
    class_counts = {}

    for class_name in os.listdir(dataset_dir):
        class_dir = os.path.join(dataset_dir, class_name)
        if os.path.isdir(class_dir):
            num_images = len([
                f for f in os.listdir(class_dir)
                if os.path.isfile(os.path.join(class_dir, f))
            ])
            class_counts[class_name] = num_images

    # Plotting
    plt.figure(figsize=(10, 6))
    plt.bar(class_counts.keys(), class_counts.values(), color='skyblue')
    plt.title('Distribusi Gambar per Kelas di original_data')
    plt.xlabel('Kelas')
    plt.ylabel('Jumlah Gambar')
    plt.xticks(rotation=45)
    plt.tight_layout()
    plt.show()

# Tampilkan grafik
plot_class_distribution('combine_data')
