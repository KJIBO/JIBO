<?php
 require_once __DIR__ . '/../../includes/functions.php';
  require_admin();
   if($_SERVER['REQUEST_METHOD']==='POST'){ $stmt=db()->prepare('INSERT INTO cars (title,brand,model,year,color,registration_number,fuel_type,transmission,seats,mileage,rental_price_per_day,sale_price,description,image,status,condition_label,car_type,is_featured) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
    $stmt->execute([$_POST['title'],$_POST['brand'],$_POST['model'],$_POST['year'],$_POST['color'],$_POST['registration_number'],$_POST['fuel_type'],$_POST['transmission'],$_POST['seats'],$_POST['mileage'],$_POST['rental_price_per_day']?:0,$_POST['sale_price']?:0,$_POST['description'],$_POST['image'],$_POST['status'],$_POST['condition_label'],$_POST['car_type'],$_POST['is_featured']]);
     redirect('/car-rent-sale-system/admin/cars/index.php');
      } 
      ?>
      <!DOCTYPE 
      html>
      <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Add Car</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="/car-rent-sale-system/assets/css/style.css">
        </head>
        <body class="dashboard-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
                    <div class="col-lg-10 p-4">
                        <div class="form-box">
                            <h1 class="mb-4">Add Car</h1>
                            <form method="post">
                                <?php include __DIR__ . '/_form.php'; ?>
                                <div class="mt-3">
                                    <button class="btn btn-primary">Save Car</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
