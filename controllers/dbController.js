const mysql = require('mysql2');

exports.fetchData = (req, res) => {
  const connection = mysql.createConnection({
    host: 'http://vs399.mirohost.net',   
    user: 'u_mishadovhi',
    password: 'UCfVlo39',
    port: 3306,
    database: 'mishadovhiy'
  });

  connection.connect((err) => {
    if (err) {
      console.error('Error connecting to the database:', err);
      return res.status(500).json({
        message: 'Database connection failed',
        error: err.message,
      });
    }
    console.log('Connected to the MySQL database.');

    const query = 'SELECT * FROM mealPlanner';

    connection.query(query, (error, results) => {
      connection.end();

      if (error) {
        console.error('Error fetching data:', error);
        return res.status(500).json({
          message: 'Error fetching data from the database',
          error: error.message,
        });
      }

      return res.status(200).json({
        message: 'Data fetched successfully',
        data: results,
      });
    });
  });
};
