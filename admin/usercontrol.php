<?php
    require '../function.php';
    
    $iduser = $_SESSION['iduser'];
    $getalluser = mysqli_query($conn, "SELECT * FROM user WHERE iduser = '$iduser'");
    $datauser = mysqli_fetch_array($getalluser);
    $email = $datauser['email'];
    $password = $datauser['password'];
    
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    if (isset($_SESSION['log']) && $_SESSION['role'] == '1') {

    } else {
        header('location: ../index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project UAS SIGT A</title>
    <link href="../css/styles.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link type="text/css" href="../css/dataTables.checkboxes.css" rel="stylesheet"/>
	<link type="text/css" href="../css/datatables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/custom.css" rel="stylesheet"/>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>

        <!-- Sidebar HTML Code Start -->
        <div id="sidebar">
	        <div class="sidebar-header">
		        <h3><img src="../img/logo.png" class="img-fluid"/><span>Project UAS</span></h3>
		    </div>
            
            <ul class="list-unstyled component m-0">
		        <li>
		            <a href="adminhome.php" class="dashboard"><i class="material-icons">category</i>Items Data </a>
		        </li>		       
                <li>
		            <a href="incomingitem.php"><i class="material-icons">inventory_2</i>Incoming Items</a>
		        </li>                
                <li>
		            <a href="exititem.php"><i class="material-icons">local_shipping</i>Exit Items</a>
		        </li>
                <li class="dropdown">
		            <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="material-icons">receipt_long</i>Transaction</a>
                    <ul class="show list-unstyled menu" id="homeSubmenu1">
		                <li><a href="requser.php">User Request</a></li>
                        <li><a href="debtreq.php">Debt Payment Request</a></li>
			            <li><a href="trdatabase.php">Transaction Database</a></li>
		            </ul>
		        </li>
                <li class="active">
		            <a href="#"><i class="material-icons">manage_accounts</i>User Control</a>
		        </li>
            </ul>
        </div>
        <!-- Sidebar HTML Code End -->
	 
        <!-- Page Content Start -->
        <div id="content"> 
		    <!-- Topbar HTML Code Start -->
		    <div class="top-navbar">
		        <div class="xd-topbar">
			        <div class="row">
				        <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
					        <div class="xp-menubar"><span class="material-icons text-white">signal_cellular_alt</span></div>
					    </div>
					 
					<div class="col-md-5 col-lg-3 order-3 order-md-2">
					</div>
					 
					<div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
					    <div class="xp-profilebar text-right">
						    <nav class="navbar p-0">
                                <ul class="nav navbar-nav flex-row ml-auto">
                                    <li class="d-flex align-content-center flex-wrap"><small>Hello, <b><?=$_SESSION['username'];?></b>!</small></li>
							        <li class="dropdown nav-item">
                                        <?php 
                                            $getemptyitem = mysqli_query($conn, "SELECT * FROM item WHERE itemtotal < 1");
                                            $rowCount = mysqli_num_rows($getemptyitem);
                                            $gettr = mysqli_query($conn, "SELECT * FROM transaction WHERE status = 1 OR status = 4 OR status = 6 OR status = 12");
                                            $tr = mysqli_num_rows($gettr);
                                            $getdb = mysqli_query($conn, "SELECT * FROM debt WHERE debtstatus = 2");
                                            $db = mysqli_num_rows($getdb);
                                        ?>
							            <a class="nav-link" href="#" data-toggle="dropdown"><span class="material-icons">notifications</span><span class="notification"><?=$rowCount+$tr+$db;?></span></a>
								            <ul class="dropdown-menu">
                                                <?php 
                                                    if ($rowCount + $tr + $db == 0) {
                                                ?>
                                                    <li><a href="#">No notifications yet</a></li>
                                                <?php                                                     
                                                    }; 
                                                    while ($fetch= mysqli_fetch_array($getemptyitem)) {
                                                        $item = $fetch['itemname'];
								                        echo '<li><a href="#"><strong class="text-danger">ALERT!</strong> <b>"'.$item.'"</b> is empty.</a></li>';
                                                    };

                                                    while ($fetchtr= mysqli_fetch_array($gettr)) {
                                                        $iduser = $fetchtr['iduser'];
                                                        $status = $fetchtr['status'];
                                                        $getuserinfo = mysqli_query($conn, "SELECT * FROM user WHERE iduser = '$iduser'");
                                                        $getinfouser = mysqli_fetch_array($getuserinfo);
                                                        $username = $getinfouser['username'];

                                                        if ($status == 1 || $status == 12) {
                                                            echo '<li><a href="#"><b>'.$username.'</b> requests to borrow items.</a></li>';
                                                        } else if ($status == 4 || $status == 6) {
                                                            echo '<li><a href="#"><b>'.$username.'</b> requests to return an item.</a></li>';
                                                        }
                                                    };

                                                    while ($fetchtr= mysqli_fetch_array($getdb)) {
                                                        $iduser = $fetchtr['iduser'];
                                                        $getuserinfo = mysqli_query($conn, "SELECT * FROM user WHERE iduser = '$iduser'");
                                                        $getinfouser = mysqli_fetch_array($getuserinfo);
                                                        $username = $getinfouser['username'];

                                                        echo '<li><a href="#"><b>'.$username.'</b> request to pay debt.</a></li>';
                                                    };
                                                ?>
								            </ul>
							        </li>
							        <li class="dropdown nav-item">
							            <a class="nav-link" href="#" data-toggle="dropdown"><img src="../img/<?=$_SESSION['image']?>" style="width:40px; border-radius:50%;"/><span class="xp-user-live"></span></a>
								        <ul class="dropdown-menu small-menu">
								            <li><a href="#profilemodal" data-toggle="modal"><span class="material-icons">person_outline</span>Profile</a></li>
								    	    <li><a href="../logout.php"><span class="material-icons">logout</span>Logout</a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    </div>

                    </div>
                    
                    <div class="xp-breadcrumbbar text-center">
				        <h4 class="page-title">Admin Dashboard</h4>
					    <ol class="breadcrumb">
					        <li class="breadcrumb-item"><a href="#">Admin access granted!</a></li>
					    </ol>
				    </div>
                </div>
		    </div>
		    <!-- Topbar HTML Code End -->
		  
            <!-- Main Content Start -->
		    <div class="main-content">
			    <div class="row">
			        <div class="col-md-12">
				        <div class="table-wrapper">
			
				            <div class="table-title card mb-4">
				                <div class="row">
					                <div class="col-sm-6 p-0 flex justify-content-lg-start justify-content-center">
						                <h2 class="ml-lg-2">User Control</h2>
						            </div>
				                </div>
				            </div>
                        </div>
                    </div>
                </div>
                
                <table id="example" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Profile</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Loan</th>
                            <th>Debt</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                            $getallitem = mysqli_query($conn, "SELECT * FROM user");
                            $i = 1;
                            while ($data = mysqli_fetch_array($getallitem)) {
                                $iduser = $data['iduser'];
                                $username = $data['username'];
                                $email = $data['email'];
                                $role = $data['role'];
                                $loan = $data['loan'];
                                $image = $data['image'];

                                $getalldebt = mysqli_query($conn, "SELECT * FROM debt WHERE iduser = '$iduser'");
                                $datadebt = mysqli_fetch_array($getalldebt);
                                if (empty($datadebt)) {

                                } else {
                                    $debt = $datadebt['debt'];
                                }
                        ?>

                        <tr id="<?=$iduser;?>">
                            <td><?=$i++;?></td>
                            <td><img src="../img/<?=$image?>" style="width:40px; border-radius:50%;"/></td>
                            <td><?=$username;?></td>
                            <td><?=$email;?></td>
                            <td>
                                <?php
                                    if ($role == 0) {
                                        echo "User";
                                    } else if ($role == 1) {
                                        echo "Admin";
                                    } else if ($role == 2) {
                                        echo "On Debt";
                                    } else if ($role == 3) {
                                        echo "Courier";
                                    } else {
                                        echo "Unknown";
                                    }
                                ?>
                            </td>
                            <td><?=$loan;?></td>
                            <td>
                                <?php 
                                    if ($debt == null) {
                                        echo "Rp ".number_format(0,2,',','.');
                                    } else {
                                        echo "Rp ".number_format($debt,2,',','.');
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if ($iduser == 1) {
                                        echo "<span class='text-danger'>Restricted</span>";
                                    } else {
                                        echo '
                                        <a class="edit" data-toggle="modal" data-target="#edit'.$iduser.'">
                                            <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                        </a>
                                        <a class="delete" data-toggle="modal" data-target="#delete'.$iduser.'">
                                            <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                                        </a>';
                                    }
                                ?>
                            </td>
                        </tr>

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="edit<?=$iduser;?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User</h5>
                                        <button type="reset" class="reset-btn" hidden>Reset</button>
                                        <button type="button" class="close reset" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="text-center">
                                                    <img src="../img/<?=$image?>" style="width:200px; height:200px; border-radius:50%;" class="img-thumbnail">

                                                </div>
        	                                </div>
                                            <div class="form-group">
                                                <label>Profile <small>(Only JPG and PNG formats with Max Size of 15 MB)</small></label>
        	                                	<input type="file" name="file" class="form-control">
                                            </div>
        	                                <div class="form-group">
                                                <label>Username</label>
        	                                	<input type="text" name="username" class="form-control" value="<?=$username;?>" required>
                                            </div>
        	                                <div class="form-group">
        	                                    <label>Email</label>
                                                <input type="email" name="email" class="form-control" value="<?=$email;?>" required>        	            
                                            </div>
        	                                <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" value="<?=$password;?>" required>
                                                <input type="hidden" name="iduser" class="form-control" value="<?=$iduser;?>" required>
        	                                </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="role" class="form-control">
                                                    <option value="<?=$role?>" disabled selected hidden>
                                                    <?php 
                                                        if ($role == 0) { 
                                                            echo "User";
                                                        } else if ($role == 1) {
                                                            echo "Admin";
                                                        } else if ($role == 2) {
                                                            echo "On Debt";
                                                        } else if ($role == 3) {
                                                            echo "Courier";
                                                        } else {
                                                            echo "Unknown";
                                                        }
                                                    ?>
                                                    </option>
                                                    <option value="0">User</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">On Debt</option>
                                                    <option value="3">Courier</option>
                                                </select>
        	                                </div>
                                            <div class="form-group">
                                                <label>Total Debt</label>
                                                <input type="number" class="form-control" name="debt" value="" placeholder="<?php echo "Rp ".number_format($debt,2,',','.');?>">
                                                <input type="hidden" class="form-control" name="debtorigin" value="<?=$debt?>;">
        	                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="reset-btn" hidden>Reset</button>
                                            <button type="button" class="btn btn-secondary reset" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success" name="userupdate">Update</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Delete User Modal -->
                        <div class="modal fade" id="delete<?=$iduser;?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete User</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <form method="post">
                                        <div class="modal-body">
                                        <p>Are you sure you want to delete "<b><?=$username;?>"</b> account?</p>
                        		        <p class="text-warning"><small>this action Cannot be Undone</small></p>
                                        <input type="hidden" name="iduser" value="<?=$iduser;?>">
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success" name="deleteuser">Delete</button>
                                    </div>
                                    </form>

                                </div>
                            </div>
                        </div> 

                        <?php 
                            }; 
                        ?>           
                    </tbody>
                </table>
            </div>

            <footer class="py-4 mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div>Copyright &copy; Kelompok SIGT 2022</div>
                        <div>Project UAS &middot; Sistem Informasi &amp; SIGT A</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Profile Modal Start -->
    <div class="modal fade" tabindex="-1" id="profilemodal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile</h5>
                    <button type="reset" class="reset-btn" hidden>Reset</button>
                    <button type="button" class="close reset" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="text-center">
                                <img src="../img/<?=$_SESSION['image']?>" style="width:200px; height:200px; border-radius:50%;" class="img-thumbnail">

                            </div>
            	        </div>
                        <div class="form-group">
                            <label>Profile <small>(Only JPG and PNG formats with Max Size of 15 MB)</small></label>
            	        	<input type="file" name="file" class="form-control">
                        </div>
            	        <div class="form-group">
                            <label>Username</label>
            	        	<input type="text" name="username" class="form-control" value="<?=$_SESSION['username'];?>" required>
                        </div>
            	        <div class="form-group">
            	            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?=$_SESSION['email'];?>" required>        	            
                        </div>
            	        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?=$_SESSION['password'];?>" required>
            	        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control" 
                            value="<?php 
                                if ($_SESSION['role'] == 0) { 
                                    echo "User";
                                } else if ($_SESSION['role'] == 1) {
                                    echo "Admin";
                                } else if ($_SESSION['role'] == 2) {
                                    echo "On Debt";
                                } else if ($_SESSION['role'] == 3) {
                                    echo "Courier";
                                } else {
                                    echo "Unknown";
                                }
                            ?>" readonly>
            	        </div>
                        <div class="form-group">
                            <label>Total Debt</label>
                            <input type="text" class="form-control" value="<?php echo "Rp ".number_format($_SESSION['debt'],2,',','.');?>" readonly>
            	        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="reset-btn" hidden>Reset</button>
                        <button type="button" class="btn btn-secondary reset" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="profileupdate">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Profile Modal End -->

    <script src="../js/jquery-3.6.1.min.js"></script>
    <script src="../js/datatables.min.js"></script>
    <script src="../js/dataTables.checkboxes.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#example').DataTable({
                'columnDefs': [{
                    'targets': 0
                }],
                'fnCreatedRow': function(nRow, aData, iDataIndex) {
                    $(nRow).attr('data-id', aData.DT_RowId);
                    $(nRow).attr('id', 'id_' + aData.DT_RowId);
                },
                'order': [
                    [0, 'asc']
                ]
            });
        });

        $(".xp-menubar").on('click',function(){
            $("#sidebar").toggleClass('active');
        	$("#content").toggleClass('active');
        });

        $('.xp-menubar,.body-overlay').on('click',function(){
            $("#sidebar,.body-overlay").toggleClass('show-nav');
        });

        $('.reset').click(function(){
            $(".reset-btn").click();
        });
    </script>
</body>
</html>