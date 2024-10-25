<link rel="stylesheet" href="/css/reviewstyle.css" />
<div
  class="modal fade"
  id="reviewModal"
  tabindex="-1"
  aria-labelledby="reviewModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewModalLabel">Bagikan Ulasan Anda</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form id="reviewForm" class="needs-validation" novalidate>
          <div class="mb-3">
            <label for="rating" class="form-label">Penilaian:</label>
            <div class="star-rating d-flex gap-1">
              <input type="radio" id="star5" name="rating" value="5" required />
              <label for="star5" title="Sempurna">★</label>
              <input type="radio" id="star4" name="rating" value="4" required />
              <label for="star4" title="Bagus">★</label>
              <input type="radio" id="star3" name="rating" value="3" required />
              <label for="star3" title="Cukup">★</label>
              <input type="radio" id="star2" name="rating" value="2" required />
              <label for="star2" title="Kurang">★</label>
              <input type="radio" id="star1" name="rating" value="1" required />
              <label for="star1" title="Buruk">★</label>
            </div>
            <div class="invalid-feedback">Silakan pilih penilaian!</div>
          </div>
          <div class="mb-3">
            <textarea
              id="ulasan"
              name="ulasan"
              rows="4"
              class="form-control"
              placeholder="Tuliskan ulasan Anda contoh: 'Barang sesuai'"
              required
            ></textarea>
            <div class="invalid-feedback">Silakan tuliskan ulasan Anda!</div>
          </div>
          <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
        </form>
      </div>
    </div>
  </div>
</div>