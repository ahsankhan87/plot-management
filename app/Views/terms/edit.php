<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>


<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Edit Terms & Conditions</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('terms/update/' . $terms['id']) ?>" method="post">
        <div class="mb-4">
            <label class="block text-sm font-medium">Title</label>
            <input type="text" name="title" value="<?= esc($terms['title']) ?>"
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium">Content</label>
            <textarea name="content" id="editor" rows="10" required><?= isset($terms) ? esc($terms['content']) : '' ?></textarea>
        </div>

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Save Changes
        </button>
    </form>
</div>

<script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content');
</script>

<?= $this->endSection() ?>