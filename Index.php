<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Basic Reset */
        body, h1, p, button {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Hero Section Style */
        .hero {
            background: url('https://via.placeholder.com/1500x800') no-repeat center center; /* Sample background image */
            background-size: cover;
            height: 100vh;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .hero .hero-content {
            max-width: 800px;
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        .hero button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .hero button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Our Service</h1>
            <p>Your solution for all needs</p>
            <button onclick="window.location.href='login.php'">Get Started</button>

        </div>
    </section>

</body>
</html>