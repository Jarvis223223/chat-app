<!-- Start of Navigation -->
<div class="navigation">
    <div class="container">
        <div class="inside">
            <div class="nav nav-tab menu">
                <i class="bi bi-bug text-primary mb-5" style='font-size: 2rem'></i>
                <a href="#members" data-toggle="tab" class="active"><i class="material-icons active">account_circle</i></a>
                <a href="#discussions" data-toggle="tab" class=""><i class="material-icons ">chat_bubble_outline</i></a>
                <a href="#settings" data-toggle="tab"><i class="material-icons ">settings</i></a>
                <li class="nav-item dropup no-arrow">
                    <a type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="avatar-md rounded-circle" src="assets/images/<?php echo $_SESSION['users']->image ?>">
                    </a>

                    <div class="dropdown-menu dropdown-menu-right"
                        aria-labelledby="userDropdown">
                        <form action="" method="post">
                            <button type="submit" name="signOutBtn" class="dropdown-item" onclick="return confirm('Are you sure')">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Sign  Out
                            </button >
                        </form>
                    </div>
                </li>
            </div>
        </div>
    </div>
</div>
<!-- End of Navigation -->

<?php 
    if (isset($_POST['signOutBtn'])) {
        $userId = $_SESSION['users']->id;
        $status = "Offline Now";
        $statement = $db->prepare("UPDATE users SET status = '$status' WHERE id=$userId");
        $result = $statement->execute();
        if ($statement) {
            session_destroy();
            header('location:sign-in.php');
        }
    }
?>