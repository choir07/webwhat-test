@echo off
echo Renaming Ideas to Posts...
echo.

REM Rename directories
ren "app\Filament\Resources\Ideas" "Posts" 2>nul

REM Rename files in Posts directory
ren "app\Filament\Resources\Posts\IdeaResource.php" "PostResource.php" 2>nul
ren "app\Filament\Resources\Posts\Pages\CreateIdea.php" "CreatePost.php" 2>nul
ren "app\Filament\Resources\Posts\Pages\EditIdea.php" "EditPost.php" 2>nul
ren "app\Filament\Resources\Posts\Pages\ListIdeas.php" "ListPosts.php" 2>nul
ren "app\Filament\Resources\Posts\Pages\ViewIdea.php" "ViewPost.php" 2>nul
ren "app\Filament\Resources\Posts\Schemas\IdeaForm.php" "PostForm.php" 2>nul
ren "app\Filament\Resources\Posts\Schemas\IdeaInfolist.php" "PostInfolist.php" 2>nul
ren "app\Filament\Resources\Posts\Tables\IdeasTable.php" "PostsTable.php" 2>nul
ren "app\Models\Idea.php" "Post.php" 2>nul
ren "app\Filament\Widgets\IdeasStats.php" "PostsStats.php" 2>nul

echo.
echo Directory and file renaming complete!
echo.
echo Now manually update file contents using VS Code find/replace
echo Find: Idea Replace: Post
echo Find: Ideas Replace: Posts
echo.

pause