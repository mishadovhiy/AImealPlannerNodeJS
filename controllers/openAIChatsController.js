const axios = require('axios');
const fs = require('fs');
const path = require('path');

//const tokenPath = path.resolve(__dirname, '../keys.json');
exports.getCalories = async (req, res) => {
//    const tokenFile = fs.readFileSync(tokenPath);
//    const tokenJson = JSON.parse(tokenFile);
    
    const foodName = req.query.foodName;
  //  const nutritionList = "calories_100g,fat_100g,proteins_100g,carbs_100g,salt_100g,sugars_100g";
    const prompt = `How many calories are in 100 grams of ${foodName}?`;
//    const prompt = `generate nutrition list in json format by this structure for 100 grams of ${foodName}, and set 0 for values that you don't know from my nutrition list`;

    const url = 'https://api.openai.com/v1/chat/completions';

    const jsonBody = {
        model: 'gpt-3.5-turbo',
        messages: [
            { role: 'system', content: 'You are a helpful assistant.' },
            { role: 'user', content: prompt }
        ],
        max_tokens: 4000,
    };

    try {
        const response = await axios.post(url, jsonBody, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer []`,
            }
        });

        res.json(response.data);
    } catch (error) {
        console.error('Error fetching data from OpenAI:', error);
        res.status(500).json({ message: 'Error fetching data from OpenAI', error: error.message });
    }
};
