from flask import Flask, request, jsonify
from flask_cors import CORS
import numpy as np
from tensorflow.keras.preprocessing.image import load_img, img_to_array
import tensorflow as tf
import os
from PIL import Image
import io
import base64

app = Flask(__name__)
CORS(app)


# Configuration
UPLOAD_FOLDER = 'uploads'
ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif'}
MAX_CONTENT_LENGTH = 16 * 1024 * 1024

app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
app.config['MAX_CONTENT_LENGTH'] = MAX_CONTENT_LENGTH

os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# Load model
try:
    model = tf.keras.models.load_model('model.h5')
    print("✅ Model loaded successfully!")
    
    # Print model details for debugging
    print(f"📊 Model input shape: {model.input_shape}")
    print(f"📊 Model output shape: {model.output_shape}")
    print(f"📊 Number of classes: {model.output_shape[-1]}")
    
except Exception as e:
    print(f"❌ Error loading model: {e}")
    model = None

# IMPORTANT: Pastikan urutan ini sama dengan yang digunakan saat training!
# Periksa kembali urutan class_names ini dengan dataset training Anda
class_names =[
 'Bercak_bakteri',
 'Bercak_daun_Septoria',
 'Bercak_Target',
 'Bercak_daun_awal',
 'Busuk_daun_lanjut',
 'Embun_tepung',
 'Jamur_daun',
 'Sehat',
 'Tungau_dua_bercak',
 'Virus_keriting_daun_kuning',
 'Virus_mosaik_tomat',
 ]

def preprocess_image(image, target_size=(224, 224)):
    from tensorflow.keras.applications.resnet50 import preprocess_input
    
    if image.mode != 'RGB':
        image = image.convert('RGB')
    
    image = image.resize(target_size)
    img_array = img_to_array(image)
    img_array = np.expand_dims(img_array, axis=0)
    
    # Use the same preprocessing as during training
    img_array = preprocess_input(img_array)  # This should match ResNet50's standard preprocessing
    
    return img_array
def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

def get_disease_info(disease_name):
    """Get disease information"""
    info = {
    'Bercak_bakteri': {
        'name': 'Bercak Bakteri',
        'symptoms': 'Bercak coklat kecil dengan tepi kuning pada daun, buah, dan batang',
        'causes': 'Bakteri Xanthomonas campestris',
        'prevention': 'Gunakan benih bebas penyakit, hindari penyiraman dari atas, rotasi tanaman',
        'treatment': 'Gunakan bakterisida yang mengandung tembaga, praktikkan rotasi tanaman',
        'severity': 'sedang'
    },
    'Bercak_daun_Septoria': {
        'name': 'Bercak Daun Septoria',
        'symptoms': 'Bercak bulat kecil dengan pusat abu-abu dan tepi coklat pada daun',
        'causes': 'Jamur Septoria lycopersici',
        'prevention': 'Hindari penyiraman dari atas, mulsa tanah, rotasi tanaman',
        'treatment': 'Hapus daun yang terinfeksi dan gunakan fungisida yang mengandung tembaga',
        'severity': 'sedang'
    },
    'Bercak_Target': {
        'name': 'Bercak Target',
        'symptoms': 'Lesi coklat dengan pola cincin target pada daun dan buah',
        'causes': 'Jamur Corynespora cassiicola',
        'prevention': 'Jaga sirkulasi udara, hindari penanaman terlalu rapat',
        'treatment': 'Gunakan fungisida dan hindari penanaman rapat',
        'severity': 'sedang'
    },
    'Bercak_daun_awal': {
        'name': 'Bercak Daun Awal',
        'symptoms': 'Lesi coklat dengan cincin konsentris pada daun, dimulai dari daun bawah',
        'causes': 'Jamur Alternaria solani',
        'prevention': 'Jaga drainase yang baik, hindari stres pada tanaman, mulsa tanah',
        'treatment': 'Gunakan fungisida yang mengandung chlorothalonil, buang daun yang terinfeksi',
        'severity': 'sedang'
    },
    'Busuk_daun_lanjut': {
        'name': 'Busuk Daun Lanjut',
        'symptoms': 'Bercak berair yang menjadi coklat pada daun dan batang, bulu putih di bawah daun',
        'causes': 'Oomycete Phytophthora infestans',
        'prevention': 'Hindari kelembaban tinggi, sirkulasi udara yang baik, tanam varietas tahan',
        'treatment': 'Gunakan fungisida sistemik seperti metalaxyl, hancurkan tanaman yang terinfeksi',
        'severity': 'tinggi'
    },
    'Embun_tepung': {
        'name': 'Embun Tepung',
        'symptoms': 'Lapisan putih seperti tepung pada permukaan daun',
        'causes': 'Jamur Leveillula atau Oidium',
        'prevention': 'Jaga sirkulasi udara, hindari kelembaban',
        'treatment': 'Gunakan fungisida sulfur atau potassium bicarbonate',
        'severity': 'sedang'
    },
    'Jamur_daun': {
        'name': 'Jamur Daun',
        'symptoms': 'Bercak kuning pada permukaan atas daun, lapisan fuzzy hijau-abu di bawah daun',
        'causes': 'Jamur Passalora fulva',
        'prevention': 'Tingkatkan sirkulasi udara, kurangi kelembaban, jaga jarak tanam',
        'treatment': 'Tingkatkan sirkulasi udara dan gunakan fungisida yang sesuai',
        'severity': 'sedang'
    },
    'Sehat': {
        'name': 'Tanaman Sehat',
        'symptoms': 'Daun hijau segar tanpa bercak',
        'causes': 'Tidak ada penyakit',
        'prevention': 'Pertahankan kondisi optimal',
        'treatment': 'Tanaman sehat, lanjutkan perawatan optimal',
        'severity': 'tidak ada'
    },
    'Tungau_dua_bercak': {
        'name': 'Tungau Dua Bercak',
        'symptoms': 'Daun menguning, bintik putih kecil, jaring laba-laba halus',
        'causes': 'Tungau Tetranychus urticae',
        'prevention': 'Jaga kelembaban udara, hindari stres kekeringan',
        'treatment': 'Gunakan mitisida atau sabun insektisida',
        'severity': 'sedang'
    },
    'Virus_keriting_daun_kuning': {
        'name': 'Virus Keriting Daun Kuning',
        'symptoms': 'Daun menguning, menggulung ke atas, pertumbuhan terhambat',
        'causes': 'Virus TYLCV oleh kutu kebul',
        'prevention': 'Kendalikan kutu kebul, gunakan mulsa reflektif',
        'treatment': 'Tanam varietas tahan, kendalikan kutu kebul',
        'severity': 'tinggi'
    },
    'Virus_mosaik_tomat': {
        'name': 'Virus Mosaik Tomat',
        'symptoms': 'Pola mosaik hijau terang dan gelap pada daun, daun keriting',
        'causes': 'Virus TMV yang menular',
        'prevention': 'Benih bebas virus, sterilisasi alat',
        'treatment': 'Hancurkan tanaman terinfeksi, sterilisasi alat',
        'severity': 'tinggi'
    }
}
    
    return info.get(disease_name, {
        'name': disease_name,
        'symptoms': 'Informasi tidak tersedia',
        'causes': 'Tidak diketahui',
        'prevention': 'Konsultasikan dengan ahli pertanian',
        'treatment': 'Konsultasikan dengan ahli setempat',
        'severity': 'unknown'
    })

@app.route('/health', methods=['GET'])
def health_check():
    """Check API and model status"""
    return jsonify({
        'success': True,
        'message': 'API is running',
        'model_loaded': model is not None,
        'status': 'healthy' if model else 'model_not_loaded',
        'model_info': {
            'input_shape': str(model.input_shape) if model else None,
            'output_shape': str(model.output_shape) if model else None,
            'num_classes': len(class_names)
        }
    })

@app.route('/predict', methods=['POST'])
def predict():
    """Classify disease from uploaded image"""
    print("🔍 Predict endpoint called")
    print(f"📁 Files in request: {list(request.files.keys())}")
    
    if model is None:
        print("❌ Model not loaded")
        return jsonify({'success': False, 'error': 'Model not loaded'}), 500

    if 'image' not in request.files:
        print("❌ No 'image' key in request.files")
        return jsonify({'success': False, 'error': 'No image provided'}), 400

    file = request.files['image']
    print(f"📷 File received: {file.filename}")
    
    if file.filename == '':
        print("❌ Empty filename")
        return jsonify({'success': False, 'error': 'No image selected'}), 400

    if not allowed_file(file.filename):
        print(f"❌ Invalid file type: {file.filename}")
        return jsonify({'success': False, 'error': 'Invalid file type'}), 400

    try:
        print("🔄 Processing image...")
        image_bytes = file.read()
        print(f"📊 Image bytes length: {len(image_bytes)}")
        
        # Open and preprocess image
        image = Image.open(io.BytesIO(image_bytes))
        print(f"🖼️ Original image - Mode: {image.mode}, Size: {image.size}")
        
        # Preprocess image
        img_array = preprocess_image(image)
        print(f"📊 Preprocessed array shape: {img_array.shape}")
        print(f"📊 Array min/max: {img_array.min():.3f}/{img_array.max():.3f}")

        print("🤖 Making prediction...")
        prediction = model.predict(img_array, verbose=0)
        print(f"📊 Raw prediction shape: {prediction.shape}")
        print(f"📊 Raw prediction: {prediction[0]}")
        
        predicted_index = np.argmax(prediction)
        predicted_class = class_names[predicted_index]
        confidence = float(np.max(prediction))
        confidence_percentage = round(confidence * 100, 2)

        print(f"📊 Predicted index: {predicted_index}")
        print(f"📊 Predicted class: {predicted_class}")
        print(f"📊 Confidence: {confidence_percentage}%")
        
        # Get top 3 predictions for debugging
        top_indices = np.argsort(prediction[0])[::-1][:3]
        print("📊 Top 3 predictions:")
        for i, idx in enumerate(top_indices):
            print(f"   {i+1}. {class_names[idx]}: {prediction[0][idx]*100:.2f}%")

        # Get disease information
        disease_info = get_disease_info(predicted_class)
        
        # Convert image to base64 for response
        image_base64 = base64.b64encode(image_bytes).decode('utf-8')
        
        print("✅ Prediction successful")
        return jsonify({
            'success': True,
            'data': {
                'classification': {
                    'class': predicted_class,
                    'class_name': disease_info['name'],
                    'confidence': confidence,
                    'confidence_percentage': confidence_percentage,
                    'is_healthy': predicted_class == 'healthy',
                    'predicted_index': int(predicted_index)
                },
                'disease_info': disease_info,
                'debug_info': {
                    'top_predictions': [
                        {
                            'class': class_names[idx],
                            'confidence': float(prediction[0][idx]),
                            'percentage': round(float(prediction[0][idx]) * 100, 2)
                        }
                        for idx in top_indices
                    ],
                    'model_input_shape': str(model.input_shape),
                    'preprocessing_applied': 'normalization_0_1'
                },
                'image_base64': image_base64
            }
        })

    except Exception as e:
        print(f"❌ Prediction error: {str(e)}")
        import traceback
        traceback.print_exc()
        return jsonify({'success': False, 'error': f'Prediction failed: {str(e)}'}), 500

@app.route('/test-classes', methods=['GET'])
def test_classes():
    """Endpoint untuk testing urutan class names"""
    return jsonify({
        'success': True,
        'data': {
            'class_names': class_names,
            'num_classes': len(class_names),
            'model_output_shape': str(model.output_shape) if model else None
        }
    })

@app.route('/diseases', methods=['GET'])
def get_diseases_info():
    """Return list of all known diseases and their descriptions"""
    try:
        data = []
        for class_name in class_names:
            data.append({
                'class': class_name,
                'info': get_disease_info(class_name)
            })
        return jsonify({'success': True, 'data': data})
    except Exception as e:
        return jsonify({'success': False, 'error': str(e)}), 500

if __name__ == '__main__':
    print("🚀 Starting Tomato Disease Classification API...")
    print(f"📦 Model loaded: {'Yes' if model is not None else 'No'}")
    if model:
        print(f"📊 Model input shape: {model.input_shape}")
        print(f"📊 Model output classes: {len(class_names)}")
    print("🌐 Endpoints:")
    print("- GET  /health")
    print("- POST /predict")
    print("- GET  /diseases")
    print("- GET  /test-classes")
    app.run(host='0.0.0.0', port=5000, debug=True)