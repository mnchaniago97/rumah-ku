import jsVectorMap from "jsvectormap";
import "jsvectormap/dist/maps/world";

const map01 = () => {
  const mapSelectorOne = document.querySelectorAll("#mapOne");

  if (mapSelectorOne.length) {
    const mapOne = new jsVectorMap({
      selector: "#mapOne",
      map: "world",
      zoomButtons: false,
      zoomOnScroll: false,
      draggable: false,
      focusOn: {
        // Padang, Sumatera Barat
        coords: [-0.95, 100.35],
        scale: 10,
        animate: false,
      },

      regionStyle: {
        initial: {
          fontFamily: "Outfit",
          fill: "#D9D9D9",
        },
        hover: {
          fillOpacity: 1,
          fill: "#465fff",
        },
      },
      markers: [
        {
          name: "Padang",
          coords: [-0.95, 100.35],
        },
        {
          name: "Bukittinggi",
          coords: [-0.3056, 100.3692],
        },
        {
          name: "Payakumbuh",
          coords: [-0.2231, 100.6310],
        },
      ],

      markerStyle: {
        initial: {
          strokeWidth: 1,
          fill: "#465fff",
          fillOpacity: 1,
          r: 4,
        },
        hover: {
          fill: "#465fff",
          fillOpacity: 1,
        },
        selected: {},
        selectedHover: {},
      },

      onRegionTooltipShow: function () {},
    });
  }
};

export default map01;
