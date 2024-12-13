// Fetch and display all tasks when the page loads
document.addEventListener("DOMContentLoaded", fetchTasks);

function fetchTasks() {
    fetch("fetch_tasks.php")
        .then((response) => response.json())
        .then((tasks) => {
            const taskList = document.getElementById("task-list");
            taskList.innerHTML = ""; // Clear the table

            tasks.forEach((task) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.title}</td>
                    <td>${task.description}</td>
                    <td>${task.due_date}</td>
                    <td>${task.status}</td>
                    <td>
                        <button onclick="deleteTask(${task.id})">Delete</button>
                        <button onclick="editTask(${task.id})">Edit</button>
                    </td>
                `;
                taskList.appendChild(row);
            });
        })
        .catch((error) => console.error("Error fetching tasks:", error));
}

// Delete a task
function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        fetch("delete_task.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: taskId }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    fetchTasks(); // Refresh the task list
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => console.error("Error deleting task:", error));
    }
}

// Load task data into the edit form
function editTask(taskId) {
    fetch(`fetch_single_task.php?id=${taskId}`)
        .then((response) => response.json())
        .then((task) => {
            if (task.id) {
                document.getElementById("edit-task-id").value = task.id;
                document.getElementById("edit-title").value = task.title;
                document.getElementById("edit-description").value = task.description;
                document.getElementById("edit-dueDate").value = task.due_date;
                document.getElementById("edit-status").value = task.status;

                // Show the edit form
                document.getElementById("edit-task-container").style.display = "block";
            } else {
                alert(task.message || "Error fetching task.");
            }
        })
        .catch((error) => console.error("Error fetching task for editing:", error));
}

// Submit the edited task
function submitEditTask(event) {
    event.preventDefault();

    const taskId = document.getElementById("edit-task-id").value;
    const title = document.getElementById("edit-title").value;
    const description = document.getElementById("edit-description").value;
    const dueDate = document.getElementById("edit-dueDate").value;
    const status = document.getElementById("edit-status").value;

    fetch("edit_task.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
            id: taskId,
            title: title,
            description: description,
            dueDate: dueDate,
            status: status,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                fetchTasks(); // Refresh the task list
                document.getElementById("edit-task-container").style.display = "none"; // Hide the edit form
            } else {
                alert(data.message || "Error updating task.");
            }
        })
        .catch((error) => console.error("Error submitting edited task:", error));
}

// Cancel editing
function cancelEditTask() {
    document.getElementById("edit-task-container").style.display = "none";
}
