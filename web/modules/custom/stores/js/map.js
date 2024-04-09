(function (Drupal, once, drupalSettings) {
  Drupal.behaviors.storesBehavior = {
    attach(context) {
      once('storesBehavior', '.map_leaflet', context).forEach(
        function (element) {
          const configId = element.getAttribute('data-config-id');
          const coordinates = drupalSettings.coordinates[configId];
          const stores = drupalSettings.stores[configId];
          const color_border = stores.color_border;
          const color = stores.color;
          const size = stores.size;
          const zoom = stores.zoom;
          const map = L.map(element).setView([51.505, -0.09], zoom);
          L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
          }).addTo(map);

          coordinates.forEach(function (locat) {
            const latitude = locat.location[0].lat;
            const longitude = locat.location[0].lon;
            let circle = L.circleMarker([latitude, longitude], {
              radius: size,
              fillColor: color,
              fillOpacity: 0.5,
              color: color_border,
            }).addTo(map);
          });
        },
      );
    },
  };
}(Drupal, once, drupalSettings));
