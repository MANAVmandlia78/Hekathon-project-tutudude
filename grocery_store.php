<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Classic Grocery Store Finder</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Crimson+Text:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Crimson Text', serif;
      background: #f8f9fa;
      min-height: 100vh;
      color: #212529;
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Header Styles */
    header {
      background: linear-gradient(135deg, #212529 0%, #343a40 100%);
      color: white;
      padding: 2rem 0;
      text-align: center;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      position: relative;
      overflow: hidden;
    }

    header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.08"/><circle cx="20" cy="80" r="0.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
      pointer-events: none;
    }

    .header-content {
      position: relative;
      z-index: 1;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
      letter-spacing: -1px;
    }

    .subtitle {
      font-size: 1.2rem;
      opacity: 0.9;
      font-weight: 400;
      letter-spacing: 0.5px;
    }

    /* Search Section */
    .search-section {
      background: white;
      margin: -30px auto 30px;
      max-width: 600px;
      border-radius: 15px;
      padding: 2rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      position: relative;
      z-index: 2;
    }

    .search-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      text-align: center;
      margin-bottom: 1.5rem;
      color: #212529;
    }

    .search-box {
      display: flex;
      border-radius: 50px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      border: 2px solid #dee2e6;
      transition: all 0.3s ease;
    }

    .search-box:focus-within {
      border-color: #212529;
      box-shadow: 0 6px 25px rgba(33, 37, 41, 0.15);
    }

    #search-input {
      flex: 1;
      padding: 15px 25px;
      font-size: 16px;
      border: none;
      outline: none;
      font-family: 'Crimson Text', serif;
      background: white;
    }

    #search-input::placeholder {
      color: #94a3b8;
      font-style: italic;
    }

    #search-btn {
      padding: 15px 30px;
      background: linear-gradient(135deg, #212529 0%, #343a40 100%);
      color: white;
      border: none;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-family: 'Crimson Text', serif;
      letter-spacing: 0.5px;
    }

    #search-btn:hover {
      background: linear-gradient(135deg, #000000 0%, #212529 100%);
      transform: translateY(-1px);
    }

    /* Main Content */
    .main-content {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 30px;
      margin-bottom: 50px;
    }

    /* Map Styles */
    .map-container {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      border: 1px solid #e2e8f0;
    }

    .map-header {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      padding: 20px;
      border-bottom: 1px solid #dee2e6;
    }

    .map-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem;
      color: #212529;
      margin: 0;
    }

    #map {
      height: 400px;
      width: 100%;
    }

    /* Store List Styles */
    .stores-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      border: 1px solid #e2e8f0;
      overflow: hidden;
    }

    .stores-header {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      padding: 20px;
      border-bottom: 1px solid #dee2e6;
    }

    .stores-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem;
      color: #212529;
      margin: 0;
      text-align: center;
    }

    .stores-content {
      padding: 20px;
      max-height: 400px;
      overflow-y: auto;
    }

    #store-list {
      list-style: none;
    }

    .store-item {
      padding: 15px;
      margin-bottom: 10px;
      background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
      border-radius: 10px;
      border-left: 4px solid #212529;
      transition: all 0.3s ease;
      cursor: pointer;
      border: 1px solid #e9ecef;
    }

    .store-item:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 15px rgba(33, 37, 41, 0.15);
      background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
      border-left-color: #000000;
    }

    .store-name {
      font-weight: 600;
      color: #212529;
      font-size: 1.1rem;
      margin-bottom: 5px;
    }

    .store-address {
      color: #6c757d;
      font-size: 0.95rem;
      font-style: italic;
    }

    .no-results {
      text-align: center;
      color: #6c757d;
      font-style: italic;
      padding: 40px 20px;
    }

    /* Footer */
    footer {
      background: linear-gradient(135deg, #212529 0%, #000000 100%);
      color: white;
      text-align: center;
      padding: 30px 0;
      margin-top: 50px;
    }

    .footer-text {
      opacity: 0.8;
      font-size: 0.95rem;
    }

    /* Loading Spinner */
    .loading {
      display: none;
      text-align: center;
      padding: 20px;
    }

    .spinner {
      border: 3px solid #f3f3f3;
      border-top: 3px solid #212529;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 1s linear infinite;
      margin: 0 auto 10px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .main-content {
        grid-template-columns: 1fr;
        gap: 20px;
      }
      
      h1 {
        font-size: 2.2rem;
      }
      
      .search-section {
        margin: -20px 20px 20px;
        padding: 1.5rem;
      }
      
      .search-box {
        flex-direction: column;
        border-radius: 15px;
      }
      
      #search-input, #search-btn {
        border-radius: 0;
      }
      
      #search-input {
        border-radius: 15px 15px 0 0;
      }
      
      #search-btn {
        border-radius: 0 0 15px 15px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="container">
      <div class="header-content">
        <h1>Grocery Store Finder</h1>
        <p class="subtitle">Discover quality markets near you</p>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="search-section">
      <h2 class="search-title">Find Your Perfect Store</h2>
      <div class="search-box">
        <input type="text" id="search-input" placeholder="Search for grocery stores near me...">
        <button id="search-btn">Search</button>
      </div>
    </div>

    <div class="main-content">
      <div class="map-container">
        <div class="map-header">
          <h3 class="map-title">Location Map</h3>
        </div>
        <div id="map"></div>
      </div>

      <div class="stores-container">
        <div class="stores-header">
          <h3 class="stores-title">Nearby Stores</h3>
        </div>
        <div class="stores-content">
          <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Finding stores near you...</p>
          </div>
          <ul id="store-list">
            <li class="no-results">Use your location or search to find nearby grocery stores</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="container">
      <p class="footer-text">Helping you find the best grocery stores since today</p>
    </div>
  </footer>

  <script>
    let map, service, infowindow, markers = [];

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 22.3039, lng: 70.8022 }, // Rajkot default
        zoom: 13,
        styles: [
          {
            "featureType": "all",
            "elementType": "geometry.fill",
            "stylers": [{"weight": "2.00"}]
          },
          {
            "featureType": "all",
            "elementType": "geometry.stroke",
            "stylers": [{"color": "#9c9c9c"}]
          },
          {
            "featureType": "all",
            "elementType": "labels.text",
            "stylers": [{"visibility": "on"}]
          },
          {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [{"color": "#f2f2f2"}]
          },
          {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#ffffff"}]
          },
          {
            "featureType": "landscape.man_made",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#ffffff"}]
          },
          {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [{"visibility": "off"}]
          },
          {
            "featureType": "road",
            "elementType": "all",
            "stylers": [{"saturation": -100}, {"lightness": 45}]
          },
          {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#eeeeee"}]
          },
          {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#7b7b7b"}]
          },
          {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [{"color": "#ffffff"}]
          },
          {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [{"visibility": "simplified"}]
          },
          {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [{"visibility": "off"}]
          },
          {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [{"visibility": "off"}]
          },
          {
            "featureType": "water",
            "elementType": "all",
            "stylers": [{"color": "#46bcec"}, {"visibility": "on"}]
          },
          {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [{"color": "#c8d7d4"}]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#070707"}]
          },
          {
            "featureType": "water",
            "elementType": "labels.text.stroke",
            "stylers": [{"color": "#ffffff"}]
          }
        ]
      });

      infowindow = new google.maps.InfoWindow();

      // Default: Search near user's location
      if (navigator.geolocation) {
        showLoading();
        navigator.geolocation.getCurrentPosition(pos => {
          const userLocation = {
            lat: pos.coords.latitude,
            lng: pos.coords.longitude
          };
          map.setCenter(userLocation);
          
          const userMarker = new google.maps.Marker({ 
            position: userLocation, 
            map, 
            title: "You are here",
            icon: {
              url: 'data:image/svg+xml;base64,' + btoa(`
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#212529" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
              `),
              scaledSize: new google.maps.Size(30, 30),
              anchor: new google.maps.Point(15, 15)
            }
          });
          
          searchNearby(userLocation);
        }, () => {
          hideLoading();
          alert("Location access denied. Please search manually or enable location services.");
        });
      }
    }

    function showLoading() {
      document.getElementById('loading').style.display = 'block';
      document.getElementById('store-list').innerHTML = '';
    }

    function hideLoading() {
      document.getElementById('loading').style.display = 'none';
    }

    function clearMarkers() {
      markers.forEach(marker => marker.setMap(null));
      markers = [];
    }

    function searchNearby(location) {
      const request = {
        location: location,
        radius: 5000,
        type: ["supermarket", "grocery_or_supermarket", "food"]
      };

      service = new google.maps.places.PlacesService(map);
      service.nearbySearch(request, callback);
    }

    function searchByText(query) {
      showLoading();
      clearMarkers();
      
      const request = { 
        query: query, 
        fields: ["name", "geometry", "formatted_address", "rating", "place_id"] 
      };

      service = new google.maps.places.PlacesService(map);
      service.textSearch(request, function(results, status) {
        hideLoading();
        if (status === google.maps.places.PlacesServiceStatus.OK && results.length > 0) {
          map.setCenter(results[0].geometry.location);
          displayResults(results);
        } else {
          document.getElementById('store-list').innerHTML = '<li class="no-results">No results found. Try a different search term.</li>';
        }
      });
    }

    function callback(results, status) {
      hideLoading();
      if (status === google.maps.places.PlacesServiceStatus.OK) {
        displayResults(results);
      }
    }

    function displayResults(results) {
      const storeList = document.getElementById("store-list");
      storeList.innerHTML = "";
      clearMarkers();
      
      if (results.length === 0) {
        storeList.innerHTML = '<li class="no-results">No stores found in this area.</li>';
        return;
      }

      results.forEach((place, index) => {
        const li = document.createElement("li");
        li.className = "store-item";
        
        const storeName = document.createElement("div");
        storeName.className = "store-name";
        storeName.textContent = place.name;
        
        const storeAddress = document.createElement("div");
        storeAddress.className = "store-address";
        storeAddress.textContent = place.vicinity || place.formatted_address || "Address not available";
        
        li.appendChild(storeName);
        li.appendChild(storeAddress);
        
        li.addEventListener('click', () => {
          map.setCenter(place.geometry.location);
          map.setZoom(16);
          
          infowindow.setContent(`
            <div style="padding: 10px; font-family: 'Crimson Text', serif;">
              <h3 style="margin: 0 0 10px 0; color: #212529;">${place.name}</h3>
              <p style="margin: 0; color: #6c757d;">${place.vicinity || place.formatted_address}</p>
              ${place.rating ? `<p style="margin: 5px 0 0 0; color: #ffc107;">⭐ ${place.rating}/5</p>` : ''}
            </div>
          `);
          infowindow.open(map, markers[index]);
        });
        
        storeList.appendChild(li);

        const marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location,
          title: place.name,
          icon: {
            url: 'data:image/svg+xml;base64,' + btoa(`
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#212529" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
            `),
            scaledSize: new google.maps.Size(30, 30),
            anchor: new google.maps.Point(15, 30)
          }
        });

        markers.push(marker);

        marker.addListener('click', () => {
          infowindow.setContent(`
            <div style="padding: 10px; font-family: 'Crimson Text', serif;">
              <h3 style="margin: 0 0 10px 0; color: #212529;">${place.name}</h3>
              <p style="margin: 0; color: #6c757d;">${place.vicinity || place.formatted_address}</p>
              ${place.rating ? `<p style="margin: 5px 0 0 0; color: #ffc107;">⭐ ${place.rating}/5</p>` : ''}
            </div>
          `);
          infowindow.open(map, marker);
        });
      });
    }

    document.getElementById("search-btn").addEventListener("click", function() {
      const query = document.getElementById("search-input").value.trim();
      if (query) {
        searchByText(query);
      } else {
        alert("Please enter a search term (e.g., 'grocery stores near me')");
      }
    });

    document.getElementById("search-input").addEventListener("keypress", function(e) {
      if (e.key === "Enter") {
        document.getElementById("search-btn").click();
      }
    });
  </script>

  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKjcvUuxoZ_XK2vpVg2ieRMNJBqhkdsj8&libraries=places&callback=initMap">
  </script>
</body>
</html>