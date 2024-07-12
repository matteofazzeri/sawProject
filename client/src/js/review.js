class Review {
  constructor() {}

  async addReview(e) {
    e.preventDefault(); // Prevent the default form submission

    console.log("first");

    loaders.show("post-rev-btn", "bubble", "");

    document.getElementById("post-rev-btn").disabled = true;

    // Get the form element
    const form = document.getElementById('review-form');

    // Get the values of the input elements
    const title = DOMPurify.sanitize(form.querySelector('#review-title').value);
    const text = DOMPurify.sanitize(form.querySelector('#review-text').value);

    // Get the value of the selected star rating
    let stars = null;
    const starInputs = form.querySelectorAll('input[name="star"]');
    starInputs.forEach(input => {
      if (input.checked) {
        stars = DOMPurify.sanitize(input.value);
      }
    });

    if(stars === null) {
      document.getElementById("star-err").innerHTML = "To make the Review you have to select a rating";
      document.getElementById("post-rev-btn").innerHTML = "Submit";
      return;
    }

    // Log the values (you can replace this with your own logic)
    console.log("Title:", title);
    console.log("Review:", text);
    console.log("Stars:", stars);

    // Add the review to the reviews array
    const bodyMessage = new URLSearchParams();
    bodyMessage.append('title', title);
    bodyMessage.append('review', text);
    bodyMessage.append('rating', stars);

    // get element id from _GET
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('eid');
    bodyMessage.append('eid', productId);

    // make the fetch request
    const response = await fetch(`${backendUrl.development}e/review`, {
      method: "POST",
      headers: {
      "Content-Type": "application/x-www-form-urlencoded"
      },
      body: bodyMessage.toString(),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Clear the form
    form.reset();
    // Hide the review box again
    document.querySelector('.rev-box').style.display = 'none';
  }

  downloadReviews() {
    // Implementation for downloading reviews
  }

  getReviewsByProductId(productId) {
    return this.reviews.filter(review => review.productId === productId);
  }
}

const r = new Review();

document.addEventListener('DOMContentLoaded', () => {

  const starInputs = document.querySelectorAll('input[name="star"]');

  starInputs.forEach(input => {

    input.addEventListener('change', () => {

      // Show the review box
      document.querySelector('.rev-box').style.display = 'block';
    });
  });
});
