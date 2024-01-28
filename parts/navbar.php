<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f2f2f2;
    }

    .dropdown {
        position: absolute;
        display: inline-block;
        cursor: pointer;

    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        min-width: 160px;
        z-index: 1;
        top: -1.5rem;
        left: -10rem;

    }

    .dropdown-content a {
        padding: 12px 16px;
        display: block;
        text-decoration: transparent;
        color: #333;
        
    }

    .dropdown-content a {
        background-color: #f9f9f900;
        
    }

    /* Remove hovering effect for the dropdown */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    .setting-icon {
        position: absolute;
        width: 2rem;
        height: 2rem;
        top: 0rem;
        right: 5rem;
        font-size: 24px;
        cursor: pointer;
        color: #333;
    }

    /* Style for the transparent button */
    .dropdown .button {
        background-color: transparent;
        color: #ffffff00; /* Text color */
        padding: 10px 20px; /* Adjust padding as needed */
        border: 2px solid #ffffff00; /* White border */
        border-radius: 5px;
        font-size: 16px; /* Adjust font size as needed */
        cursor: pointer;
        /* Remove hovering effect for the button */
        /* transition: background-color 0.3s, color 0.3s; */
    }
</style>

<nav class="navbar" style="margin-top:3rem; margin-bottom:-3rem;">
    <div style="display:flex; margin-left: 20rem; font-size: 1.25rem;">
          <a class="nav-link" href="home.php" style="font-weight: bold;">Profile</a> <a class="nav-link" href="Newsfeed.php" style="font-weight: bold;">Newsfeed</a> <a class="nav-link" href="plan.php" style="font-weight: bold;">Plan a Trip</a>
    </div>
      <div class="navbar-icons">
      <div class="dropdown">
        <button class = "button"><img class="setting-icon" src="Images\settings.png"/></button>
        <div class="dropdown-content">
          <a href="\Atlas\EditProfile.php">Edit Profile</a>
          <a href="\Atlas\LogOut.php" onclick="logOut()">Log Out</a>
        </div>
      </div>
      </div>

      <img src="Images/Horizontal white line.png" style="width: 100%;
                                                        height: 10rem; margin-top:-4rem;
                                                        position: relative;
                                                        z-index: 0;"/>
    </nav>
<script>

  function logOut() {
    
    alert('Logging out...');
    // You can replace the alert with your own logic for logging out.
  }
</script>
