import tensorflow as tf


import pandas as pd
import os
import shutil
from tqdm import tqdm as tq
import pathlib
import gdown
import zipfile
import numpy as np
import random

from sklearn.preprocessing import LabelEncoder
import matplotlib.pyplot as plt
import math
from keras.utils import to_categorical
from tensorflow.keras.utils import load_img, img_to_array
import tensorflow as tf
from tensorflow import keras
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Input,Conv2D, MaxPooling2D, Flatten, Dense, Dropout, GlobalAveragePooling2D
from tensorflow.keras.regularizers import l2
from tensorflow.keras.layers import BatchNormalization
from tensorflow.keras.applications import ResNet50
from tensorflow.keras.applications.resnet50 import preprocess_input
from tensorflow.keras.layers import Activation
from sklearn.model_selection import train_test_split
from tensorflow.keras.preprocessing.image import ImageDataGenerator
from tensorflow.keras.callbacks import EarlyStopping, ReduceLROnPlateau, Callback
from tensorflow.keras.optimizers import Adam

# ID file Google Drive
file_id = '1a1wuqIntWWd36fFVhVSFXkaEfRp8Q4Wr'
zip_name = 'combine_data.zip'

# Download file dari Google Drive
#gdown.download(f'https://drive.google.com/uc?id={file_id}', zip_name, quiet=False)

# Buat folder untuk ekstrak
extract_path = 'combine_data'
os.makedirs(extract_path, exist_ok=True)

# Ekstrak ZIP
with zipfile.ZipFile(zip_name, 'r') as zip_ref:
    zip_ref.extractall(extract_path)

# Lihat isi folder
os.listdir(extract_path)


mypath = "combine_data"

file_name = []
labels = []
full_path = []
for path, subdirs, files in os.walk(mypath):
    for name in files:
        full_path.append(os.path.join(path, name))
        labels.append(path.split('/')[-1])
        file_name.append(name)

df = pd.DataFrame({"path":full_path,'file_name':file_name,"labels":labels})
df.groupby(['labels']).size()

df.info()

X= df['path']
y= df['labels']


#Split Data Training:Validation:Testing = 70:15:15

# Split 15% untuk test
X_temp, X_test, y_temp, y_test = train_test_split(X, y, test_size=0.15, stratify=y, random_state=42)

# Dari 85% data sisa, ambil 15/85 ≈ 0.176 untuk validation, sisanya jadi train
X_train, X_val, y_train, y_val = train_test_split(X_temp, y_temp, test_size=0.176, stratify=y_temp, random_state=42)


df_tr = pd.DataFrame({'path': X_train, 'labels': y_train, 'set': 'train'})
df_val = pd.DataFrame({'path': X_val, 'labels': y_val, 'set': 'val'})
df_te = pd.DataFrame({'path': X_test, 'labels': y_test, 'set': 'test'})

df_all = pd.concat([df_tr, df_val, df_te]).reset_index(drop=True)

# Print hasil untuk melihat panjang size data training, validation, dan testing
print('Train size:', len(df_tr))
print('Validation size:', len(df_val))
print('Test size:', len(df_te))


# Gabungkan semuanya menjadi satu DataFrame akhir
df_all = pd.concat([df_tr, df_val, df_te]).reset_index(drop=True)

# Gabungkan DataFrame df_tr, df_val, dan df_te
df_all = pd.concat([df_tr, df_val, df_te], ignore_index=True)

print('===================================================== \n')
print(df_all.groupby(['set', 'labels']).size(), '\n')
print('===================================================== \n')

# Cek sample data
print(df_all.sample(5))


datasource_path = "combine_data"
dataset_path = "Dataset-Final/"

for index, row in tq(df_all.iterrows()):
    # Deteksi filepath
    file_path = row['path']
    if os.path.exists(file_path) == False:
      file_path = os.path.join(datasource_path,row['labels'],row['image'].split('.')[0])

    # Buat direktori tujuan folder
    if os.path.exists(os.path.join(dataset_path,row['set'],row['labels'])) == False:
        os.makedirs(os.path.join(dataset_path,row['set'],row['labels']))

    # Tentukan tujuan file
    destination_file_name = file_path.split('/')[-1]
    file_dest = os.path.join(dataset_path,row['set'],row['labels'],destination_file_name)

    # Salin file dari sumber ke tujuan
    if os.path.exists(file_dest) == False:
        shutil.copy2(file_path,file_dest)

# Define training, validation, and test directories
TRAIN_DIR = "Dataset-Final/train/"
VAL_DIR = "Dataset-Final/val/"
TEST_DIR = "Dataset-Final/test/"


# Augmentasi data training
train_datagen = ImageDataGenerator(
    preprocessing_function=preprocess_input,
    rotation_range=20,
    width_shift_range=0.2,
    height_shift_range=0.2,
    shear_range=0.2,
    zoom_range=0.2,
    brightness_range=(0.8, 1.2),
    horizontal_flip=True,
    fill_mode='nearest'
)

# Preprocessing data validation
validation_datagen = ImageDataGenerator(preprocessing_function=preprocess_input)

# Preprocessing data test
test_datagen = ImageDataGenerator(preprocessing_function=preprocess_input)

# Membuat generator data
train_generator = train_datagen.flow_from_directory(
    TRAIN_DIR,
    target_size=(224, 224),
    batch_size=128,
    class_mode='categorical'
)

validation_generator = validation_datagen.flow_from_directory(
    VAL_DIR,
    target_size=(224, 224),
    batch_size=128,
    class_mode='categorical'
)

test_generator = test_datagen.flow_from_directory(
    TEST_DIR,
    target_size=(224, 224),
    batch_size=128,
    class_mode='categorical',
    shuffle=False
)

base_model = ResNet50(weights='imagenet', include_top=False, input_shape=(224, 224, 3))
base_model.trainable = True
for layer in base_model.layers[:-20]:
    layer.trainable = False
feature_extractor = Sequential([
    Input(shape=(224, 224, 3)),
    base_model,
])

model = Sequential([
    feature_extractor,
    Conv2D(256, (3, 3), activation='relu', padding='same', kernel_regularizer=l2(0.001)),
    BatchNormalization(),
    MaxPooling2D(pool_size=(2, 2)),

    Conv2D(128, (3, 3), activation='relu', padding='same', kernel_regularizer=l2(0.001)),
    BatchNormalization(),
    MaxPooling2D(pool_size=(2, 2)),

    GlobalAveragePooling2D(),

    Dense(512, activation='relu', kernel_regularizer=l2(0.001)),
    Dropout(0.4),
    Dense(256, activation='relu', kernel_regularizer=l2(0.001)),
    Dropout(0.3),
    Dense(128, activation='relu', kernel_regularizer=l2(0.001)),
    Dropout(0.2),
    Dense(11, activation='softmax')
])

model.summary()


from tensorflow.keras.callbacks import EarlyStopping, ReduceLROnPlateau, Callback
class AccuracyThresholdStopping(Callback):
    def __init__(self, target_accuracy=0.96):
        super().__init__()
        self.target_accuracy = target_accuracy
        self.last_train_accuracy = 0
        self.last_val_accuracy = 0

    def on_epoch_end(self, epoch, logs=None):
        self.last_val_accuracy = logs.get('val_accuracy')
        self.last_train_accuracy = logs.get('accuracy')

        if self.last_val_accuracy is not None and self.last_train_accuracy is not None:
            if self.last_val_accuracy >= self.target_accuracy and self.last_train_accuracy >= self.target_accuracy:
                print(f"\nTraining dan Validation accuracy sudah mencapai {self.target_accuracy*100:.1f}%, menghentikan training.")
                self.model.stop_training = True

    def on_train_end(self, logs=None):
        print(f"\nAkurasi terakhir Training: {self.last_train_accuracy*100:.2f}%")
        print(f"Akurasi terakhir Validation: {self.last_val_accuracy*100:.2f}%")

# EarlyStopping berdasarkan akurasi, kalau tidak meningkat
early_stopping = EarlyStopping(monitor='val_accuracy', patience=10, restore_best_weights=True, min_delta=0.01)

# Reduce learning rate jika akurasi validasi tidak meningkat
reduce_lr = ReduceLROnPlateau(monitor='val_accuracy', factor=0.2, patience=5, min_lr=0.0001)

# Custom Callback untuk target 95%
accuracy_stop = AccuracyThresholdStopping(target_accuracy=0.96)

model.compile(
    optimizer=Adam(learning_rate=0.001),
    loss='categorical_crossentropy',
    metrics=['accuracy']
)

steps_per_epoch = math.ceil(train_generator.samples / train_generator.batch_size)
validation_steps = math.ceil(validation_generator.samples / validation_generator.batch_size)

# Fit model dengan callbacks yang sudah disesuaikan
hist = model.fit(
    train_generator,
    epochs=15,
    validation_data=validation_generator,
    steps_per_epoch=steps_per_epoch,
    validation_steps=validation_steps,
    callbacks=[early_stopping,accuracy_stop,reduce_lr]
)

acc = hist.history['accuracy']
val_acc = hist.history['val_accuracy']
loss = hist.history['loss']
val_loss = hist.history['val_loss']

epochs = range(len(acc))

plt.plot(epochs, acc, 'r')
plt.plot(epochs, val_acc, 'b')
plt.title('Training and Validation Accuracy')
plt.ylabel('accuracy')
plt.xlabel('epoch')
plt.legend(['train', 'val'], loc='upper left')
plt.show()

plt.plot(epochs, loss, 'r')
plt.plot(epochs, val_loss, 'b')
plt.ylabel('loss')
plt.xlabel('epoch')
plt.legend(['train', 'val'], loc='upper left')
plt.title('Training and Validaion Loss')
plt.show()

# Evaluasi model menggunakan data test
loss, accuracy = model.evaluate(test_generator, verbose=1)

print(f"Loss: {loss:.4f}")
print(f"Accuracy: {accuracy:.4f}")

# Simpan model ke dalam folder 'saved_model_Resnet50'
save_path = os.path.join("saved_model_Resnet50")
tf.saved_model.save(model, save_path)

# Zip folder model
import shutil
shutil.make_archive('saved_model_Resnet50', 'zip', 'saved_model_Resnet50')


from google.colab import files
files.download('saved_model_Resnet50.zip')

model.save("model.h5")

# Install tensorflowjs
import os
os.system("pip install tensorflowjs")


# Convert model.h5 to model
subprocess.run(["tensorflowjs_converter", "--input_format=keras", "model.h5", "tfjs_model"], check=True)


# Zip folder tfjs_model dengan nama tfjs_model_Resnet50.zip
shutil.make_archive("tfjs_model_Resnet50", "zip", "tfjs_model")

# Lihat isi dan ukuran file zip (opsional)
zip_path = "tfjs_model_Resnet50.zip"
if os.path.exists(zip_path):
    size_bytes = os.path.getsize(zip_path)
    print(f"Zip file created: {zip_path} ({round(size_bytes / 1024, 2)} KB)")
else:
    print("Gagal membuat file ZIP.")

# Unduh file zip
from google.colab import files
files.download('tfjs_model_Resnet50.zip')

# 1. Convert SavedModel ke TFLite
converter = tf.lite.TFLiteConverter.from_saved_model('saved_model_Resnet50')  # ganti sesuai nama folder yang benar
tflite_model = converter.convert()

# 2. Buat folder 'tflite/'
os.makedirs('tflite', exist_ok=True)

# 3. Simpan model.tflite di dalam tflite/
tflite_model_path = pathlib.Path('tflite/model.tflite')
tflite_model_path.write_bytes(tflite_model)

# 4. Simpan label.txt di dalam tflite/
labels = list(train_generator.class_indices.keys())
with open('tflite/label.txt', 'w') as f:
    for label in labels:
        f.write(f"{label}\n")


# 5. Zip folder tflite dengan nama yang sesuai
shutil.make_archive("tflite_Resnet50", 'zip', "tflite")

print("Folder 'tflite' berhasil di-zip menjadi 'tflite_Resnet50.zip'")

# 6. Download file zip
files.download('tflite_Resnet50.zip')

# Path folder data dan model
base_dir = 'combine_data'
model_path = 'saved_model_Resnet50'

# Load model
model = tf.saved_model.load(model_path)
infer = model.signatures["serving_default"]

# List semua kelas
kelas_list = os.listdir(base_dir)
kelas_list.sort()

# Jumlah gambar yang akan dicek?
jumlah_gambar = 10

for i in range(jumlah_gambar):
    # --- Ambil gambar random ---
    kelas_random = random.choice(kelas_list)
    kelas_path = os.path.join(base_dir, kelas_random)
    gambar_random = random.choice(os.listdir(kelas_path))
    gambar_path = os.path.join(kelas_path, gambar_random)

    # --- Load gambar ---
    img = load_img(gambar_path, target_size=(224, 224))
    img_array = img_to_array(img)
    img_array = np.expand_dims(img_array, axis=0)
    img_array = preprocess_input(img_array)

    # --- Prediksi ---
    input_tensor = tf.convert_to_tensor(img_array)
    prediction = infer(input_tensor)

    # Ambil output prediksi
    for key in prediction.keys():
        output = prediction[key]
        break

    predicted_index = np.argmax(output.numpy(), axis=-1)[0]
    predicted_class_name = kelas_list[predicted_index]

    # --- Print hasil ---
    print("="*50)
    print(f"[{i+1}]")
    print(f"Gambar dipilih : {gambar_path}")
    print(f"Hasil Prediksi : {predicted_class_name}")


# Path folder data dan model
base_dir = 'combine_data'
model_path = 'saved_model_Resnet50'

# Load model
model = tf.saved_model.load(model_path)
infer = model.signatures["serving_default"]

# List semua kelas
kelas_list = os.listdir(base_dir)
kelas_list.sort()

# Jumlah gambar yang akan dicek
jumlah_gambar = 10

for i in range(jumlah_gambar):
    # --- Ambil gambar random ---
    kelas_random = random.choice(kelas_list)
    kelas_path = os.path.join(base_dir, kelas_random)
    gambar_random = random.choice(os.listdir(kelas_path))
    gambar_path = os.path.join(kelas_path, gambar_random)

    # --- Load gambar ---
    img = load_img(gambar_path, target_size=(224, 224))
    img_array = img_to_array(img)
    img_array = np.expand_dims(img_array, axis=0)
    img_array = preprocess_input(img_array)

    # --- Prediksi ---
    input_tensor = tf.convert_to_tensor(img_array)
    prediction = infer(input_tensor)

    # Ambil output prediksi
    for key in prediction.keys():
        output = prediction[key]
        break

    predicted_index = np.argmax(output.numpy(), axis=-1)[0]
    predicted_class_name = kelas_list[predicted_index]

    # --- Tampilkan hasil ---
    print("="*50)
    print(f"[{i+1}]")
    print(f"Gambar dipilih : {gambar_path}")
    print(f"Hasil Prediksi : {predicted_class_name}")

    # --- Tampilkan gambar ---
    plt.imshow(load_img(gambar_path))
    plt.title(f"Prediksi: {predicted_class_name}")
    plt.axis('off')
    plt.show()

# Simpan model dalam format .h5
model.save("model.h5")
print(f"Model disimpan sebagai model.h5 (Ukuran: {os.path.getsize('model.h5')/(1024*1024):.2f} MB)")

# Verifikasi model bisa di-load
try:
    test_model = tf.keras.models.load_model('model.h5')
    test_model.summary()
    print("✅ Model berhasil di-load kembali")
except Exception as e:
    print(f"❌ Gagal memuat model: {str(e)}")
    exit()