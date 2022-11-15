<nav class="navbar navbar-expand-lg  navbar-dark">
        <div class="container">
            <div class="first-content w-50">
                <a href='dashboard.php'><img src="layout/images/logo.png"></a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="second-content collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="subjects.php">Subjects</a></li>
                    <li><a href="groups.php">Groups</a></li>
                    <li><a href="places.php">Places</a></li>
                    <li><a href="members.php">Members</a></li>
                    <li><a href="#"><span class="dropdown-toggle" role="button" data-bs-toggle="collapse" data-bs-target="#navbarDropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?><span class="caret"></span></span></a></li>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" id="navbarDropdown">
                        <li><a href="../index.php">General Page</a></li>
                        <li><a href="profile.php?userid=<?php echo $_SESSION['UserID']; ?>">Profile</a></li>
                        <li><a href="members.php?do=edit&id=<?php echo $_SESSION['UserID']; ?>">Edit Profile</a></li>
                        <li><a href="logout.php">LogOut</a></li>
                    </ul>
                </ul>
            </div>
        </div>
    </nav>
