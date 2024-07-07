class Review {
  constructor() {
    this.reviews = [];
  }

  addReview(review) {
    this.reviews.push(review);
  }

  getReviews() {
    return this.reviews;
  }

  getReviewsByProductId(productId) {
    return this.reviews.filter(review => review.productId === productId);
  }
}

