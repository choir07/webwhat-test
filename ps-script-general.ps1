# init-git.ps1
cd C:\Users\User\webwhat

Write-Host "Initializing Git repository..." -ForegroundColor Yellow

# Initialize git
git init

# Add all files (respecting .gitignore)
git add .

# Create initial commit
git commit -m "Initial commit: Laravel blog with Filament admin panel

- Complete blog system with posts, categories, tags
- Filament v5 admin panel
- Frontend blog with Tailwind CSS
- Comments system
- Dark/Light mode toggle
- Image upload and gallery support
- SEO fields
- Responsive design"

Write-Host "Git initialized and committed!" -ForegroundColor Green