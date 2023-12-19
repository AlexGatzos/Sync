// <!-- <?php
// // getCredentials.php
// require_once('0_CustomerData.php');

// header('Content-Type: application/json');

// $credentials = [
//     PYL_API_USERNAME => 'eshop',
//     PYL_API_PASSWORD => 'LJUCS58C1WYW2VA',
// ];

//  json_encode($credentials);
// ?> -->

// Import React and necessary modules
import React, { useEffect, useState } from 'react';
import axios from 'axios';

// Define the SyncComponent
const SyncComponent = () => {
  const [progress, setProgress] = useState(0);
  const [information, setInformation] = useState('Συγχρονισμός Ειδών. Παρακαλώ Περιμένετε...');

  // Function to perform synchronization
  const performSync = async () => {
    try {
      const response = await axios.get('/path/to/synchronize.php'); // Προσαρμόστε το URI του PHP script
      console.log(response.data); // Χειριστείτε τα δεδομένα απάντησης όπως χρειάζεται
    } catch (error) {
      console.error('Σφάλμα κατά τη διάρκεια του συγχρονισμού:', error);
    }
  };

  // useEffect to simulate synchronization progress
  useEffect(() => {
    const totalSteps = 4;

    const simulateSync = async () => {
      for (let step = 0; step < totalSteps; step++) {
        setProgress((step + 1) / totalSteps * 100);
        switch (step) {
          case 0:
            setInformation('Συγχρονισμός Ειδών. Παρακαλώ Περιμένετε...');
            break;
          case 1:
            setInformation('Συγχρονισμός Χαρακτηριστικών. Παρακαλώ Περιμένετε...');
            break;
          case 2:
            setInformation('Συγχρονισμός Φωτογραφιών Χαρακτηριστικών Ειδών. Παρακαλώ Περιμένετε...');
            break;
          case 3:
            setInformation('Ο Συγχρονισμός ολοκληρώθηκε! Τώρα μπορείτε να κλείσετε το παράθυρο.');
            break;
          default:
            break;
        }

        await new Promise(resolve => setTimeout(resolve, 1000)); // Προσομοίωση καθυστέρησης, προσαρμόστε ανάλογα
      }
    };

    simulateSync();
    performSync(); // Καλέστε τη συνάρτηση συγχρονισμού εδώ
  }, []);

  // Return the JSX for the component
  return (
    <div className="container">
      <h2>Συγχρονισμός Ειδών</h2>
      <h5 id="wait">Μην κλείσετε το παράθυρο!</h5>
      <div className="progress" style={{ height: '4%' }}>
        <div className="progress-bar progress-bar-striped active" role="progressbar" style={{ width: `${progress}%` }}></div>
      </div>
      <div id="information" style={{ fontSize: '130%' }}>{information}</div>
    </div>
  );
};

export default SyncComponent;
