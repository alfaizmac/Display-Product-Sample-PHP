<div class="Main">
    <div class="Input">
        <div class="headerModal">
            <h2>Add product</h2>
        </div>
        <form action="handler/addProduct.php" method="post" enctype="multipart/form-data" class="inputContainer">
            <img id="profile-picture" src="img/default.png" alt="Image">
            <button type="button" id="upload-profile-btn">Upload Image</button>
            <input type="file" id="Profile_Image_Path" name="Profile_Image_Path" accept="image/*"
                style="display: none;">

            <div class="contianer">
                <span>Product Name:</span>
                <div class="inputName">
                    <input type="text" name="product_name" required>
                </div>
            </div>
            <div class="contianer">
                <span>Description:</span>
                <div class="inputDescription">
                    <textarea name="description" required></textarea>
                </div>
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</div>
<script>
    document.querySelector('form').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch('addProduct.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert(result.message);
                window.location.href = 'index.php'; // Redirect after success
            } else {
                alert('Error: ' + result.message);
                if (result.errors) console.error(result.errors);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while submitting the form');
        }
    });
</script>
<style>
    * {
        padding: 0;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #fff;
    }

    .inputContainer {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .image-preview {
        max-width: 300px;
        max-height: 300px;
        width: auto;
        height: auto;
        border: 2px dashed #ccc;
        padding: 10px;
        margin-bottom: 10px;
        object-fit: contain;
    }


    .inputContainer img {
        margin-top: 20px;
        display: block;
        max-width: 100%;
        height: auto;
        background: #fff;
        border: 1px solid #fff;
    }

    .main {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .uploadImg {
        display: flex;
        height: auto;
        width: 100%;
    }

    .inputContainer button {
        width: 200px;
        height: 60px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 500;
        background: #05071c;
        border: none;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .inputContainer button:hover {
        background: #121a68;
        font-size: 18px;
    }

    .Input {
        display: flex;
        flex-direction: column;
        height: auto;
        width: 500px;
        background: linear-gradient(0deg, #341f7c, #602fd4 80%);
        border-radius: 12px;
        border: 1px solid #fbfbfb;
        padding: 10px 15px 10px 15px;
    }

    .inputContainer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .contianer {
        display: flex;
        flex-direction: row;
        justify-content: start;
    }

    .contianer {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;

    }

    .contianer span {
        display: flex;
        white-space: nowrap;
        font-size: 18px;
        font-weight: 500;
        margin-right: 20px;
        width: 200px;
    }

    .inputName {
        display: flex;
        width: 100%;
        height: 60px;
        align-items: center;
        justify-content: center;
        border: 1px solid #fbfbfb;
        background-color: rgb(255, 255, 255, 0.05);
        border-radius: 12px;
    }

    .inputName input {
        display: flex;
        width: 100%;
        border-radius: 12px;
        border: none;
        font-size: 18px;
        color: #fff;
        background: transparent;
        padding-left: 20px;
    }

    .inputName input:focus {
        outline: none;
    }

    .inputDescription {
        display: flex;
        width: 100%;
        height: auto;
        align-items: center;
        justify-content: center;
    }

    .inputDescription textarea {
        display: flex;
        width: 100%;
        height: 120px;
        border-radius: 12px;
        border: none;
        font-size: 18px;
        color: #fff;
        background: transparent;
        padding: 10px 20px 10px 20px;
        border: 1px solid #fbfbfb;
        background-color: rgb(255, 255, 255, 0.05);
        border-radius: 12px;
    }

    .inputDescription input:focus {
        outline: none;
    }
</style>