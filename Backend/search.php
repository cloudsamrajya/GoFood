<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php 
session_start();
include '../DB/connect.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Reults - GoFood</title>
    <style>
        .search-resutls-container{
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .search-header{
            margin-bottom: 30px;
            text-align: center;
        }
        .search-query{
            font-weight: bold;
            color: #e67e22;
        }
        .results-count{
            color: #7f8c8d;
            margin-top: 10px;
        }
        .product-container{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 90px;
            margin-top: 30px;

        }
        .no-results{
            text-align: center;
            padding: 50px;
            color: #7f8c8d;
        }
        .back-to-home{
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="search-results-container">
        <?php
        /// to get the search query
        $searchQuery = isset($_GET['query']) ? trim($_GET['query']) : ''; 
        if(!empty($searchQuery)){
            $stmt = $conn -> prepare("SELECT DISTINCT r.* FROM restaurant r LEFT JOIN food_item f ON r.restaurant_id = f.restaurant_id WHERE r.name LIKE :search OR f.name LIKE :search OR f.category LIKE :search ");
            $stmt -> execute([':search' => "%$searchQuery%"]);
            $restaurants = $stmt -> fetchAll();
            $resultsCount = count($restaurants);
            ?>
            <div class="search-header">
                <h2>Search Results for "<span class ="search-query"><?php echo htmlspecialchars($searchQuery); ?> </span>"</h2>
                <div class="result-count">
                    <?php echo $resultsCount; ?> results found </div>
                </div>
                <?php if($resultsCount > 0): ?>
                    <div class="product-container">
                        <?php foreach($restaurants as $r): ?>
                            <div class="featured-product-div">
                                <a href="restaurant.php?restaurant_id=<?php echo $r['restaurant_id'];?>" class="anchor">
                                    <div class="featured-product-div-img" style="cursor: pointer;">
                                        <img src="<?php echo $r['image']; ?>" alt="<?php echo htmlspecialchars($r['name']); ?>" class="featured-img">
                                    </div>
                                    <div class="featured-product-div-title" style="cursor: pointer;">
                                        <?php echo htmlspecialchars($r['name']); ?>
                                    </div>
                        </a> 
                            </div>
                            <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <div class="no-results">
                            <h3>No results found</h3>
                            <p>We couldn't find any restaurants or dishes matching your search</p>
                            <a href="index.php" class="back-to-home">Back to Home</a>
                        </div>
                        <?php endif; ?>
                        <?php } else { ?>
                            <div class="no-results">
                  <h3>No search query provided</h3>
                 <p>Please enter a search term to find restaurants or dishes.</p>
                 <a href="index.php" class="back-to-home">Back to Home</a>
                            </div>
                            <?php } ?>
            </div>
        



        
    
    <?php include 'footer.php'; ?>
    
</body>
</html>
