<style>
    .title-field {
        margin-bottom: 10px;
        
    }
    .title-field label {
        display: block;
        margin-bottom: 5px;
    }
    .title-field input {
        border: 1px solid #ced4da;
        border-radius: 5px;
        width: 100%;
        padding: 5px;
    }
    .content-field {
        margin-bottom: 10px;
    }
    .content-field label {
        display: block;
        margin-bottom: 5px;
    }
    .content-field textarea {
        border: 1px solid #ced4da;
        border-radius: 5px;
        width: 100%;
        padding: 5px;
    }
    .submit-container {
        margin-top: 10px;
    }
    .submit-container button {
        font-size: large;
        border-radius: 5px;
        padding: 5px 10px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }
    .submit-container button:hover {
        background-color: #0056b3;
    }
</style>

<form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="title-field">
        <label for="title" >Title</label>
        <input type="text" name="title" id="title">
    </div>

    <div class="content-field">
        <label for="content" >Content</label>
        <textarea name="content" id="content" rows="5" ></textarea>
    </div>

    <label for="image_url">Image</label>
    <input type="file" name="image_url" id="image_url">
    <div class="image-field">
        
    </div>

    <div class="submit-container">
        <button type="submit" >Create Post</button>
    </div>
</form>