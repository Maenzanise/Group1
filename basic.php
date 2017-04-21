<?php include 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <!--Only admin to be able to see this-->
                <li><a href="#">Link 1</a></li>
                
                <li><a href="#">Link 2</a></li>
                <li><a href="#">Link 3</a></li>
            </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>

            <div class="well well-sm">
                This is a well for any information or text you wish to show.
            </div>

            <h2 class="sub-header">Heading</h2>
                This is page specific content.
            </div>
    </div>
</div>
<?php include 'includes/footer.php';