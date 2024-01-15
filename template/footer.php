    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
        <div id="refreshStart"></div>
        <div id="output"></div>
        <h4>&copy; <?=date('Y')?>. Benas Ponetauskas ir Rokas Stankūnas</h4>
        <p>The Github project can be found <a href="https://github.com/archlich03/spotlister">here</a>. Pls like and share.</p>
    </footer>

    <!-- End page content -->
</div>

<script>
    var mySidebar = document.getElementById("mySidebar");

    var overlayBg = document.getElementById("myOverlay");

    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }

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
            document.getElementById('refreshStart').textContent = "Refresh started. Do not interrupt this process.";
            getOutput();
            setTimeout(updateTimer, 1000);
        } else {
            let countdown = `${formatTime(remainingMinutes)}:${formatTime(remainingSeconds)}`;
            document.getElementById('timer').textContent = countdown;
        }
    }

    let timerInterval = setInterval(updateTimer, 1000);

    document.getElementById('fetchOutputLink').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('refreshStart').textContent = "Refresh started. Do not interrupt this process.";
        getOutput();
    });

    updateTimer();
</script>