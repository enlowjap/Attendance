<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Tara G-Bike</title>
    <link rel="icon" href="/picture/bicycle.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .contact-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none; /* Prevent textarea from being resized */

        }

        .form-group textarea {
            height: 150px;
        }

        .form-group button {
            background-color: #007bff;
            color: #fff;
            width: 104%;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .error {
            color: #dc3545;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <?php include 'navigationheader.php'; ?>

    <div class="container">
        <h1>Contact Us</h1>
        <div class="contact-form">
            <form id="contactForm">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <div class="error" id="nameError"></div>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <div class="error" id="emailError"></div>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                    <div class="error" id="messageError"></div>
                </div>
                <div class="form-group">
                    <button type="submit">Send Message</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const contactForm = document.getElementById('contactForm');

        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Clear previous error messages
            document.getElementById('nameError').textContent = '';
            document.getElementById('emailError').textContent = '';
            document.getElementById('messageError').textContent = '';

            const formData = new FormData(contactForm);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', 'send_message.php', true);

            // Basic form validation
            if (formData.get('name').trim() === '') {
                document.getElementById('nameError').textContent = 'Please enter your name.';
                return;
            }

            if (formData.get('email').trim() === '') {
                document.getElementById('emailError').textContent = 'Please enter your email address.';
                return;
            }

            if (formData.get('message').trim() === '') {
                document.getElementById('messageError').textContent = 'Please enter your message.';
                return;
            }

            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Your message has been sent successfully!');
                    contactForm.reset();
                } else {
                    alert('An error occurred. Please try again later.');
                }
            };

            xhr.onerror = function () {
                alert('An error occurred. Please try again later.');
            };

            xhr.send(formData);
        });
    </script>
</body>
</html>
