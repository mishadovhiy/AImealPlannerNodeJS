const axios = require('axios');
const FormData = require('form-data');
const fs = require('fs');
const path = require('path');

exports.analyzeImage = async (req, res) => {
  if (!req.file) {
    return res.status(400).json({ message: 'No file uploaded' });
  }

  const filePath = req.file.path; 

  const form = new FormData();
  
  form.append('image', fs.createReadStream(filePath), {
    filename: 'image.jpg',
    contentType: 'image/jpeg',
  });

  const url = 'https://vision.foodvisor.io/api/1.0/en/analysis';
//    const tokenPath = path.resolve(__dirname, '../keys.json');


  try {
  //    const tokenFile = fs.readFileSync(tokenPath);
    //  const tokenJson = JSON.parse(tokenFile);
    const response = await axios.post(url, form, {
      headers: {
        ...form.getHeaders(),
        'Authorization': `Api-Key []`,
      },
    });

    res.status(200).json({
      message: 'Image analyzed successfully',
      data: response.data,
    });
  } catch (error) {
    console.error('Error during image analysis request:', error);
    
    res.status(500).json({
      message: 'Image analysis failed',
      error: error.response ? error.response.data : 'Unknown error',
    });
  } finally {
    fs.unlink(filePath, (err) => {
      if (err) {
        console.error('Error deleting the file:', err);
      }
    });
  }
};
