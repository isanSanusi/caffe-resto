<header>
    <div>
        <a href="index.php">Sans caffe & resto.</a>
    </div>
    <div>
        <?php 
            if(isset($_SESSION['is_login'])) {
                echo "<div class='right'>";
                echo "<a href='report.php' class='btn_header'>Report</a>";
                echo "<a href='logout.php' class='btn_header'>Logout</a>";
                echo "</div>";
            } else {
                echo "<a href='login.php' class='btn_header'>Login</a>";
            }
        ?>
    </div>
</header>