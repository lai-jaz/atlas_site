<div class="col-md-2 sidebar">
    <img src="\Atlas\Images\atlas logo.png" style="width: 40%; height: auto; margin: 2rem;" />

        <div style="padding:2rem; padding-top:5rem;">
        <div class="profile-images-container">
        <!-- Profile picture -->
        <img src="<?php echo $_SESSION['profilePic']?>" alt="Profile Image" class="profile-image">
        <img src="\Atlas\Images\Outline.png" class="overlapping-image">
        </div>
        <!-- User info -->
        <br><h5 style="font-weight: bold;"><?php echo $_SESSION['firstName'] . ' ' . $_SESSION['lastName']; ?></h5>
        <p><?php echo $_SESSION['email']?></p>
        <a href="roammates.php" class="nav-link"><p style="font-weight: bold; font-size: 1.25rem;">Roammates</p></a>
        <a href="home.php" class="nav-link"><p style="font-weight: bold; font-size: 1.25rem;">Home</p></a>
        </div>
      </div>