const articlesToDelete = [...document.querySelectorAll('.delete-article')];

articlesToDelete.forEach(btnArticle => btnArticle.addEventListener('click', deleteArticle));

function deleteArticle() {
    if (confirm('Are you sure?')) {
        const id = event.target.dataset.id;

        fetch(`/article/delete/${id}`, { method: 'DELETE' }).then(res => window.location.reload());
    }
}
