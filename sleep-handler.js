const express = require('express');
const { exec } = require('child_process');
const app = express();

app.post('/api/sleep', (req, res) => {
  // Programmer le réveil à demain 7h et mettre en sommeil
  exec('echo $(date -d "tomorrow 07:00" +%s) > /sys/class/rtc/rtc0/wakealarm && pm-suspend', (err) => {
    if (err) {
      res.status(500).json({ error: err.message });
    } else {
      res.json({ status: 'Mise en veille programmée' });
    }
  });
});

app.listen(3001, () => console.log('Sleep API on :3001'));