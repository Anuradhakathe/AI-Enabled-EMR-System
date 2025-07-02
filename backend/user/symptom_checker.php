<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

$diagnosis = $suggestedDoctors = $remedies = $err = "";
$showResults = false;

if (isset($_POST['analyze']) && !empty(trim($_POST['symptoms']))) {
    $showResults = true;
    $symptoms = strtolower(trim($_POST['symptoms']));

    // Basic keyword-based diagnosis (can be replaced with ML model)
    if (strpos($symptoms, 'cough') !== false || strpos($symptoms, 'cold') !== false) {
        $diagnosis = "You may be experiencing symptoms of a common cold or respiratory infection.";
        $target_dept = 'ENT';
        $remedies = "Stay hydrated, take steam inhalation, and consider antihistamines.";
    } elseif (strpos($symptoms, 'headache') !== false || strpos($symptoms, 'blurred vision') !== false) {
        $diagnosis = "Possible signs of a migraine or neurological issue.";
        $target_dept = 'Neurology';
        $remedies = "Avoid screen time, rest in a quiet dark room, consider over-the-counter pain relief.";
    } elseif (strpos($symptoms, 'chest pain') !== false || strpos($symptoms, 'breathlessness') !== false) {
        $diagnosis = "Symptoms indicate a potential cardiovascular issue.";
        $target_dept = 'Cardiology';
        $remedies = "Seek medical attention immediately, avoid exertion.";
    } else {
        $diagnosis = "Symptoms are non-specific. Further examination required.";
        $target_dept = 'General';
        $remedies = "Monitor your condition, maintain hydration and a balanced diet.";
    }

    // Fetch doctors from suggested department
    $stmt = $mysqli->prepare("SELECT * FROM his_docs WHERE doc_dept LIKE ?");
    $like_dept = "%$target_dept%";
    $stmt->bind_param("s", $like_dept);
    $stmt->execute();
    $suggestedDoctors = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom Checker - AI Powered EMR</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="icon" href="../../backend/admin/assets/images/favicon.ico">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .card-box {
            max-width: 700px;
            margin: 40px auto;
            border-radius: 10px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        textarea {
            resize: vertical;
        }
        footer {
            margin-top: auto;
        }
        #analyzing-message {
            display: none;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white text-center py-4">
        <h1>AI Symptom Checker</h1>
    </header>

    <div class="container">
        <div class="card-box">
            <form method="post" id="symptomForm">
                <div class="form-group">
                    <label>Describe your symptoms:</label>
                    <textarea name="symptoms" id="symptomsInput" rows="4" class="form-control" required></textarea>
                </div>
                <button type="submit" name="analyze" class="btn btn-success btn-block">Analyze Symptoms</button>
            </form>

            <div class="mt-4 alert alert-info" id="analyzing-message">
                <strong>Please wait...</strong> We are analyzing your symptoms.
            </div>

            <div id="results-box" style="display: <?php echo $showResults ? 'block' : 'none'; ?>;">
                <?php if ($diagnosis): ?>
                    <div class="mt-4 alert alert-primary">
                        <strong>Diagnosis:</strong> <?php echo $diagnosis; ?>
                    </div>
                    <div class="alert alert-warning">
                        <strong>Suggested Remedies:</strong> <?php echo $remedies; ?>
                    </div>

                    <?php if ($suggestedDoctors && $suggestedDoctors->num_rows > 0): ?>
                        <h5 class="mt-4">Recommended Doctors:</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($doc = $suggestedDoctors->fetch_object()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($doc->doc_fname . ' ' . $doc->doc_lname); ?></td>
                                        <td><?php echo htmlspecialchars($doc->doc_dept); ?></td>
                                        <td><a href="book_appointment.php?doc_id=<?php echo $doc->doc_id; ?>" class="btn btn-sm btn-primary">Book Appointment</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-muted">No doctors found for this department.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 bg-light mt-auto">
        <p class="mb-0">&copy; 2025 AI Powered EMR System. All rights reserved.</p>
    </footer>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('symptomForm').addEventListener('submit', function(e) {
            const textarea = document.getElementById('symptomsInput');
            if (textarea.value.trim() === '') {
                e.preventDefault();
                alert("Please enter your symptoms before analyzing.");
            } else {
                document.getElementById('analyzing-message').style.display = 'block';
            }
        });
    </script>
</body>
</html>