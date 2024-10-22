<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <link href="https://fonts.cdnfonts.com/css/helvetica-neue-55" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .voting-section {
            background: linear-gradient(145deg, rgba(245, 246, 252, 0.8), rgba(255, 255, 255, 0.6));
            padding: 60px;
            border-radius: 25px;
            box-shadow: 0 12px 50px rgba(0, 122, 255, 0.1);
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            font-size: 2.8rem;
            margin-bottom: 25px;
            color: rgba(0, 122, 255, 0.85);
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        canvas {
            width: 100% !important;
            max-width: 450px;
            height: auto !important;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="voting-section">
        <h1>Voting Results</h1>
        <!-- Chart for OSIS Votes -->
        <canvas id="osisChart"></canvas>
        <br>
        <!-- Chart for MPS Votes -->
        <canvas id="mpsChart"></canvas>
        <br>
        <!-- Chart for LDP Votes -->
        <canvas id="ldpChart"></canvas>
    </div>

    <script>
        async function fetchData() {
            const response = await fetch('csv/voted.csv');
            const data = await response.text();

            const rows = data.split('\n').slice(1);
            const osisVotes = [0, 0, 0];
            const mpsVotes = [0, 0];
            const ldpVotes = [0, 0];

            rows.forEach(row => {
                const cols = row.split(',');
                const osisVote = cols[1];
                const mpsVote = cols[2];
                const ldpVote = cols[3];

                if (osisVote === '1') osisVotes[0]++;
                if (osisVote === '2') osisVotes[1]++;
                if (osisVote === '3') osisVotes[2]++;

                if (mpsVote === '1') mpsVotes[0]++;
                if (mpsVote === '2') mpsVotes[1]++;

                if (ldpVote === '1') ldpVotes[0]++;
                if (ldpVote === '2') ldpVotes[1]++;
            });

            return { osisVotes, mpsVotes, ldpVotes };
        }

        async function renderCharts() {
            const { osisVotes, mpsVotes, ldpVotes } = await fetchData();

            const osisData = {
                labels: ['Paslon 1', 'Paslon 2', 'Paslon 3'],
                datasets: [{
                    data: osisVotes,
                    backgroundColor: [
                        'rgba(0, 122, 255, 0.6)',
                        'rgba(52, 199, 89, 0.6)', 
                        'rgba(255, 149, 0, 0.6)' 
                    ],
                    hoverBackgroundColor: [
                        'rgba(0, 122, 255, 0.8)',
                        'rgba(52, 199, 89, 0.8)',
                        'rgba(255, 149, 0, 0.8)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1
                }]
            };

            const mpsData = {
                labels: ['Paslon 1', 'Paslon 2'],
                datasets: [{
                    data: mpsVotes,
                    backgroundColor: [
                        'rgba(0, 122, 255, 0.6)', 
                        'rgba(255, 45, 85, 0.6)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(0, 122, 255, 0.8)',
                        'rgba(255, 45, 85, 0.8)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1
                }]
            };

            const ldpData = {
                labels: ['Paslon 1', 'Paslon 2'],
                datasets: [{
                    data: ldpVotes,
                    backgroundColor: [
                        'rgba(0, 122, 255, 0.6)',
                        'rgba(88, 86, 214, 0.6)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(0, 122, 255, 0.8)',
                        'rgba(88, 86, 214, 0.8)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 1
                }]
            };

            const options = {
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            };

            new Chart(document.getElementById('osisChart'), {
                type: 'pie',
                data: osisData,
                options: options
            });

            new Chart(document.getElementById('mpsChart'), {
                type: 'pie',
                data: mpsData,
                options: options
            });

            new Chart(document.getElementById('ldpChart'), {
                type: 'pie',
                data: ldpData,
                options: options
            });
        }

        renderCharts();
    </script>
</body>
</html>
