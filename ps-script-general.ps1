# add-remote-and-push.ps1
cd C:\Users\User\webwhat

# Replace YOUR_USERNAME and YOUR_REPO_NAME with your actual GitHub info
$githubUsername = "choir07"  # CHANGE THIS
$repoName = "webwhat-test"          # CHANGE THIS

Write-Host "Adding remote repository..." -ForegroundColor Yellow

# Add remote origin
git remote add origin https://github.com/$githubUsername/$repoName.git

# Push to GitHub
git branch -M main
git push -u origin main

Write-Host "Pushed to GitHub successfully!" -ForegroundColor Green
Write-Host "https://github.com/$githubUsername/$repoName" -ForegroundColor Cyan