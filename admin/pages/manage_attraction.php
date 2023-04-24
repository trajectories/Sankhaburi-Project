<?php
session_start();

// Check if the session is active and valid
if (!session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['user_id'])) {
  // Session is not active and valid, user is logged in
  header('Location: login.html');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Manage Tourist Attractions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-QFw0AXcTnFvTQWtDl9tKT1xjjRV1m0AxmWt7iFGs38nJ46/90eZj8WAn+y1AXXHbfRZMKNnwvN8f60G+wqHOyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">

</head>

<body>
  <div class="container">
    <h2 class="text-center my-4">Manage Tourist Attractions</h2>
    <div class="row mb-3">
      <div class="col-md-8">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
          <i class="fas fa-plus"></i> Add Attraction
        </button>
      </div>
      <div class="col-md-4">
        <input class="form-control" id="search-input" type="text" placeholder="Search...">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Telephone</th>
            <th>Location Map</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="attraction-list">
          <!-- AJAX will populate this table -->
        </tbody>
      </table>
    </div>
  </div>

  <!-- Add Attraction Modal -->
  <div class="modal fade" id="addModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Tourist Attraction</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="add-form">
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="tel">Telephone:</label>
              <input type="tel" class="form-control" id="tel" name="tel" required>
            </div>
            <div class="form-group">
              <label for="map">Location Map:</label>
              <textarea class="form-control" id="map" name="map" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Attraction Modal -->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Tourist Attraction</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="edit-form">
          <div class="modal-body">
            <input type="hidden" id="edit-id" name="id">
            <div class="form-group">
              <label for="edit-name">Name:</label>
              <input type="text" class="form-control" id="edit-name" name="name" required>
            </div>
            <div class="form-group">
              <label for="edit-description">Description:</label>
              <textarea class="form-control" id="edit-description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="edit-tel">Telephone:</label>
              <input type="tel" class="form-control" id="edit-tel" name="tel" required>
            </div>
            <div class="form-group">
              <label for="edit-map">Location Map:</label>
              <textarea class="form-control" id="edit-map" name="map" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Delete Attraction Modal -->
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Tourist Attraction</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form id="delete-form">
          <div class="modal-body">
            <p>Are you sure you want to delete this attraction?</p>
            <input type="hidden" id="delete-id" name="id">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Custom JS -->
  <script>
    // Fetch all attractions from the database and display them in the table
    function loadAttractions() {
      $.ajax({
        url: 'fetch_attractions.php',
        type: 'GET',
        success: function(response) {
          $('#attractions-table').html(response);
        }
      });
    }

    $(document).ready(function() {
      // Load attractions on page load
      loadAttractions();

      // Add attraction form submission
      $('#add-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: 'add_attraction.php',
          type: 'POST',
          data: $('#add-form').serialize(),
          success: function(response) {
            if (response == 'success') {
              $('#addModal').modal('hide');
              loadAttractions();
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Attraction added successfully.',
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error adding attraction. Please try again.',
              });
            }
          }
        });
      });

      // Edit attraction form submission
      $('#edit-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: 'edit_attraction.php',
          type: 'POST',
          data: $('#edit-form').serialize(),
          success: function(response) {
            if (response == 'success') {
              $('#editModal').modal('hide');
              loadAttractions();
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Attraction updated successfully.',
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error updating attraction. Please try again.',
              });
            }
          }
        });
      });

      // Delete attraction form submission
      $('#delete-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: 'delete_attraction.php',
          type: 'POST',
          data: $('#delete-form').serialize(),
          success: function(response) {
            if (response == 'success') {
              $('#deleteModal').modal('hide');
              loadAttractions();
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Attraction deleted successfully.',
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error deleting attraction. Please try again.',
              });
            }
          }
        });
      });
    });
  </script>
</body>

</html>