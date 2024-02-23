<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Cities</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Center the form vertically and horizontally */
    .centered-form {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 50vh;
    }
    .centered-results {
      display: flex;
      justify-content: center;
      align-items: center;
      /* height: 50vh; */
    }

    @media (max-width: 576px) {
      .centered-form {
        padding: 0 15px;
      }
    }
  </style>
</head>
<body>

<div class="container">
    <div class="row centered-form">
        <div class="col-md-6">
            <form id="searchForm" class="form-inline">
                <div class="form-group mr-2">
                    <label for="country" class="mr-2">Country</label>
                    <select class="form-control" id="country" name="country">
                        <option value="">Select a country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <ul class="results" id="results"></ul>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

    // hardcoded countries in config due to rate limit issue on the API
    // function loadCountries() {
    //     $.ajax({
    //     type: 'GET',
    //     url: '{{ route('api.country.list') }}',
    //     success: function(response) {
    //         var { data } = response;
    //         var countries = data.map(function(country) {
    //         return `<option value="${country.code}">${country.name}</option>`;
    //         }).join('');
    //         $('#country').html(countries);
    //     },
    //     error: function(xhr, status, error) {
    //         // Handle error
    //         console.error(error);
    //     }
    //     });
    // }

  $(document).ready(function() {
    // loadCountries();
    $('#searchForm').submit(function(event) {
      event.preventDefault();

      // Get form data
      var formData = $(this).serialize();

      $.ajax({
        type: 'GET',
        url: '{{route('api.country.search')}}',
        data: formData,
        success: function(response) {
            $('#results').html(response);
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });
</script>

</body>
</html>
