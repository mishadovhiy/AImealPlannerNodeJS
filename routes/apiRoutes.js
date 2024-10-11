const express = require('express');
const multer = require('multer');
const imageAnalysisController = require('../controllers/imageAnalysisController');
//const dbController = require('../controllers/dbController');
const openAIChatsController = require('../controllers/openAIChatsController');

const router = express.Router();
const upload = multer({ dest: 'uploads/' });

router.post('/imageAnalysis', upload.single('image'), imageAnalysisController.analyzeImage);
router.get('/get-calories', openAIChatsController.getCalories);
//router.get('/fetchData', dbController.fetchData);

module.exports = router;
