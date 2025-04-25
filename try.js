// script.js
document.getElementById('waterQualityForm').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent form from submitting the traditional way

    // Collecting form data
    const location = document.getElementById('location').value;
    const pH = document.getElementById('pH').value;
    const temperature = document.getElementById('temperature').value;
    const turbidity = document.getElementById('turbidity').value;
    const comments = document.getElementById('comments').value;

    // Creating a result object
    const formData = {
        location,
        pH,
        temperature,
        turbidity,
        comments
    };

    // Displaying the submitted data
    const outputDiv = document.getElementById('output');
    outputDiv.innerHTML = `<pre>${JSON.stringify(formData, null, 2)}</pre>`;
});
