<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Facebook Post</title>
<link rel="stylesheet" href="styles.css">

<style>
    body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.post {
    border: 1px solid #ccc;
    padding: 20px;
    max-width: 400px;
    text-align: center;
}

button {
    background-color: #1877f2;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    margin-bottom: 10px;
}

button:hover {
    background-color: #135e96;
}

#likeCount {
    font-weight: bold;
    margin-left: 5px;
}

</style>
</head>


<body>
<div class="post">
    <p>This is a Facebook-like post!</p>
    <button id="likeBtn" onclick="likePost()">Like</button>
    <span id="likeCount">0</span> Likes
</div>

<script>
let likeCount = 0;

function likePost() {
   
    likeCount++;
    
    document.getElementById('likeCount').textContent = likeCount;
}

</script>



</body>
</html>
