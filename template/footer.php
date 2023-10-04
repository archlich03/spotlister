<div id="footer">
    &copy; <?=date('Y')?> Rokas ir Benas; For any inquiries, please contact <a href="mailto:webmaster@rokascyber.lt">webmaster@rokascyber.lt</a>
</div>
<script>
    function getOutput() {
        fetch('fetch_output.php')
           .then(response => response.text())
           .then(data => {
               document.getElementById('output').innerHTML = data;
           })
           .catch(error => console.error('Error:', error));
    }

    function updateTimer() {
            const now = new Date();
            const currentMinutes = now.getMinutes();
            const currentSeconds = now.getSeconds();
            const remainingMinutes = 59 - currentMinutes;
            const remainingSeconds = 60 - currentSeconds;
            const formatTime = (value) => {
                return value < 10 ? `0${value}` : value;
            };

            if (remainingMinutes === 0 && remainingSeconds === 0) {
                clearInterval(timerInterval);
                document.getElementById('timer').textContent = "00:00:00";
                getOutput();

                setTimeout(updateTimer, 1000);
            } else {

                let countdown = `00:00`;
                if (remainingSeconds != 60)
                    document.getElementById('timer').textContent = `${formatTime(remainingMinutes)}:${formatTime(remainingSeconds)}`;
                else
                    document.getElementById('timer').textContent = `${formatTime(remainingMinutes+1)}:00`;
            }
        }

    document.getElementById('fetchOutputLink').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('refreshStart').textContent = "Refresh started. Do not interrupt this process.";
        getOutput();
    });

    updateTimer();

    const timerInterval = setInterval(updateTimer, 1000);
</script>
