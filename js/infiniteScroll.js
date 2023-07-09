var limit = 5;
var offset = 0;
var reachedEnd = false;

function showLoadingAnimation() {
  var loadingHTML = `
    <div id="loading" class="text-center">
      <i class="fas fa-spinner fa-spin"></i>
    </div>
  `;
  document.querySelector(".posts").insertAdjacentHTML("beforeend", loadingHTML);
}

function hideLoadingAnimation() {
  var loadingElement = document.getElementById("loading");
  if (loadingElement) {
    loadingElement.remove();
  }
}

function loadMorePosts() {
  if (reachedEnd) return;

  showLoadingAnimation();

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_posts.php?limit=" + limit + "&offset=" + offset, true);

  xhr.onload = function () {
    hideLoadingAnimation();

    if (this.status === 200) {
      var response = JSON.parse(this.responseText);

      if (response.length === 0) {
        reachedEnd = true;
      } else {
        response.forEach(function (post) {
          var postHTML = `
            <div class="post-preview">
              <a href="post/${post.post_id}">
                <h2 class="post-title">${post.post_title}</h2>
                <h3 class="post-subtitle">${post.post_content.substr(
                  0,
                  155
                )}...</h3>
              </a>
              <p class="post-meta">
                Paylaşan
                <a href="#!">@${post.author}</a>
                ${post.created_at}
              </p>
            </div>
            <hr class="my-4" />
          `;
          document
            .querySelector(".posts")
            .insertAdjacentHTML("beforeend", postHTML);
        });

        offset += limit;
      }
    }
  };

  xhr.send();
}

loadMorePosts();

window.addEventListener("scroll", function () {
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
    loadMorePosts();
  }
});
