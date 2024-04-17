function generateGrid(size, lights_on_positions) {
  const gridContainer = $("#grid-container");
  gridContainer.empty();

  for (let row = 0; row < size; row++) {
    const rowDiv = $("<tr></tr>");
    for (let col = 0; col < size; col++) {
      const colDiv = $('<td class="cell" scope="col"></td>');
      colDiv.attr("id", row + "-" + col);
      if (
        lights_on_positions.some(
          (position) => position[0] === row && position[1] === col
        )
      ) {
        colDiv.addClass("light-on");
      }
      rowDiv.append(colDiv);
    }
    gridContainer.append(rowDiv);
  }
}

function cellToggle() {
  // toggle cell
  $(this).toggleClass("light-on");

  // toggle adjacent cells
  var [rowStr, colStr] = $(this).attr("id").split("-");
  var row = parseInt(rowStr);
  var col = parseInt(colStr);
  var adjacentCells = [
    $(`#${row - 1}-${col}`), // top
    $(`#${row + 1}-${col}`), // bottom
    $(`#${row}-${col - 1}`), // left
    $(`#${row}-${col + 1}`), // right
  ];
  adjacentCells.forEach(function (adjCell) {
    adjCell.toggleClass("light-on");
  });
}

$(document).ready(function () {
  $("#setup-form").on("submit", function (event) {
    event.preventDefault();
    const form = event.target;
    const size = form.elements["size-input"].value;

    $(".alert.alert-success").css("display", "none");

    let lights_on_postitions;
    $.post(
      "setup.php",
      { size: size }, // data object of POST variables
      function (res) {
        // callback on success
        lights_on_postitions = res.lights_on_positions;

        // generate the grid
        generateGrid(size, lights_on_postitions);

        // bind click event handler
        $(".cell").each(function () {
          $(this).on("click", function () {
            if ($(".light-on").length !== 0) cellToggle.call(this);

            // check for game over
            if ($(".light-on").length === 0)
              $(".alert.alert-success").css("display", "block");
          });
        });
      }
    ).fail(function () {
      console.error("Failed to retrieve positions");
    });
  });
});
