<h1>
Create New Page
</h1>


<form method="POST" action="/admin/pages/store">


<div class="mb-3">

<label>
Title
</label>

<input 
class="form-control"
type="text"
name="title"
required>

</div>



<div class="mb-3">

<label>
Slug
</label>

<input 
class="form-control"
type="text"
name="slug"
placeholder="about">

</div>



<div class="mb-3">

<label>
Hero Title
</label>

<input 
class="form-control"
type="text"
name="hero_title">

</div>



<div class="mb-3">

<label>
Hero Subtitle
</label>

<input 
class="form-control"
type="text"
name="hero_subtitle">

</div>



<div class="mb-3">

<label>
Main Heading
</label>

<input 
class="form-control"
type="text"
name="main_heading">

</div>



<div class="mb-3">

<label>
Content
</label>

<textarea
class="form-control"
name="main_content"
rows="8"></textarea>

</div>



<div class="mb-3">

<label>
SEO Title
</label>

<input
class="form-control"
type="text"
name="seo_title">

</div>



<div class="mb-3">

<label>
SEO Description
</label>

<textarea
class="form-control"
name="seo_description"></textarea>

</div>



<div class="mb-3">

<label>
Status
</label>

<select
class="form-control"
name="status">


<option value="published">
Published
</option>


<option value="draft">
Draft
</option>


</select>

</div>



<button class="btn btn-success">

Create Page

</button>


<a href="/admin/pages"
class="btn btn-secondary">

Cancel

</a>


</form>