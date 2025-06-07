import tensorflow as tf
import os
import pathlib

def convert_to_tflite():
    try:
        # 1. Verifikasi model.h5 ada
        if not os.path.exists('model.h5'):
            raise FileNotFoundError("File model.h5 tidak ditemukan")
        
        print(f"Ukuran model.h5: {os.path.getsize('model.h5') / (1024*1024):.2f} MB")
        
        # 2. Load model
        model = tf.keras.models.load_model('model.h5')
        print("Model berhasil dimuat")
        
        # 3. Convert ke TFLite
        converter = tf.lite.TFLiteConverter.from_keras_model(model)
        converter.optimizations = [tf.lite.Optimize.DEFAULT]
        tflite_model = converter.convert()
        
        # 4. Buat folder tflite jika belum ada
        tflite_dir = 'tflite'
        pathlib.Path(tflite_dir).mkdir(exist_ok=True)
        
        # 5. Simpan model
        tflite_path = os.path.join(tflite_dir, 'model.tflite')
        with open(tflite_path, 'wb') as f:
            f.write(tflite_model)
        
        print(f"Model TFLite berhasil disimpan di {tflite_path}")
        print(f"Ukuran model.tflite: {os.path.getsize(tflite_path) / (1024*1024):.2f} MB")
        
        # 6. Simpan labels
        labels = [
            'Bacterial_spot',
            'Early_blight', 
            'Late_blight',
            'Leaf_Mold',
            'Septoria_leaf_spot',
            'Spider_mites Two-spotted_spider_mite',
            'Target_Spot',
            'Tomato_Yellow_Leaf_Curl_Virus',
            'Tomato_mosaic_virus',
            'healthy',
            'powdery_mildew'
        ]
        
        with open(os.path.join(tflite_dir, 'label.txt'), 'w') as f:
            for label in labels:
                f.write(f"{label}\n")
        
        print("Label berhasil disimpan")
        
        return True
    except Exception as e:
        print(f"Error selama konversi: {str(e)}")
        return False

if __name__ == '__main__':
    if convert_to_tflite():
        print("Proses konversi berhasil!")
    else:
        print("Proses konversi gagal!")