export function addChangeListener(selectElement, selectedElement) {
    selectElement.addEventListener('change', function() {
        const selectedIndex = selectElement.selectedIndex;
        const selectedOption = selectElement.options[selectedIndex];
        selectedElement.textContent = selectedOption.text;
    });

    // Display the first option by default
    const firstOption = selectElement.options[0];
    selectedElement.textContent = firstOption.text;
}
