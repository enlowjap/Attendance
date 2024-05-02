<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Tara G-Bike</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #4F6F52;
            padding-bottom: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1A4D2E;

        }
        .container h1{
            color: #000;
        }
        .container p{
            color: #fefefe;
        }

        .about-section {
            background-color: #1A4D2E;
            padding: 50px 0;
        }

        .features-section, .benefits-section {
            padding: 50px 0;
        }

        .feature {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: inline-block;
            width: calc(33.33% - 20px);
            vertical-align: top;
            margin-right: 10px;
            margin-bottom: 20px;
            background-color: #F5EFE6;
            
        }

        .feature:last-child {
            margin-right: 0;
        }

        .feature h2 {
            color: #2c2c2c;
        }
        .feature p{
            color: #2c2c2c ; 
            
        }
        .benefits-section{
            position: relative;
            left: 0px; /* Adjust this value to move the card horizontally */
            top: -70px; /* Adjust this value to move the card vertically */
        }
        .benefits-card {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 30px;
            position: relative;
            left: 1px; /* Adjust this value to move the card horizontally */
            top: -10px; /* Adjust this value to move the card vertically */
        }

        .benefits-section ul {
            list-style-type: disc;
            padding-left: 20px;
        }
        .benefits-section ul {
            list-style-type: disc;
            padding-left: 20px;
        }
    </style>
</head>
<body>

    <?php include 'navigationheader.php'; ?>

    <div class="about-section">
        <div class="container">
            <h1>About Tara G-Bike</h1>
            <p>Tara G-Bike is your online haven for cyclists who crave the thrill of exploring new routes and building a supportive community. Whether you're a seasoned route mapper or a curious newcomer, we connect you with the best paths and the people who love them.</p>
        </div>
    </div>

    <div class="features-section">
        <div class="container">
            <h2>Our Features</h2>
            <div class="feature">
                <h3>Route Repository</h3>
                <p>Find and share meticulously crafted cycling routes. Upload your own routes, complete with detailed descriptions, elevation profiles, and photos.</p>
            </div>
            <div class="feature">
                <h3>Filter and Search</h3>
                <p>Narrow down your search for the perfect route based on distance, difficulty, terrain, and cycling style (road, mountain, gravel).</p>
            </div>
            <div class="feature">
                <h3>Community Forum</h3>
                <p>Post route reviews, discuss road conditions, and share tips with fellow cyclists. Get recommendations for new adventures and connect with riding buddies who share your passion.</p>
            </div>
        </div>

        
    </div>

    <div class="benefits-section">
        <div class="container">
            <div class="benefits-card">
                <h2>Benefits of Joining</h2>
                <ul>
                    <li>Upload your favorite routes: Share your cycling expertise and inspire others.</li>
                    <li>Discover hidden gems: Find routes tailored to your preferences and explore new cycling experiences.</li>
                    <li>Connect with fellow riders: Discuss routes, challenges, and the joy of cycling.</li>
                    <li>Empower a collaborative spirit: Help build a comprehensive resource for cyclists of all levels.</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
