# GitHub 

[玩玩GitHub中的Pull Request]: https://www.bilibili.com/video/BV1ei4y1s7pU/?spm_id_from=333.337.search-card.all.click&amp;vd_source=98bed7c6ffbd4c5daae519aceb54cc51
[GitHub issue 解释]: https://www.bilibili.com/video/BV1EP411d7Np/?p=2
[GitHub Pull Request 解释 ]: https://www.bilibili.com/video/BV1EP411d7Np/?p=3&amp;spm_id_from=pageDriver&amp;vd_source=98bed7c6ffbd4c5daae519aceb54cc51



```
git clone http....
```



```
=================
```

## 小知识

`GitHub` 和 `GitLab` 的 Issue 功能虽然名称相同，但在不同的平台上有着不同的实现和用途。

在 GitHub 上，Issue 主要用于跟踪任务、建议、错误报告或其他项目相关的事项。它们更像是一个开放的讨论和反馈平台，团队成员和项目的外部贡献者可以在其中提出问题、讨论解决方案，并在需要时创建相关的 Pull Request 来解决这些问题。

而在 GitLab 上，Issue 功能也可以用于跟踪任务和问题，但它更加紧密地与代码管理和合并请求（Merge Request）结合在一起。在 GitLab 中，Issue 可以与特定的合并请求相关联，从而使得开发人员能够更轻松地在解决问题的过程中追踪代码更改的状态，并将相关的更改集中在一个地方。

因此，尽管 GitHub 和 GitLab 都提供了 Issue 功能用于跟踪任务和问题，但它们的重点和用途略有不同。GitHub 的 Issue 更像是一个开放的讨论平台，而 GitLab 的 Issue 则更紧密地与代码管理和合并请求结合在一起，更适用于开发团队的协作和项目管理。

```
=================
```



## 在Repositories 打开新项目

##### …or create a new repository on the command line

```
echo "# vue-rabbit" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/HooWC/vue-rabbit.git
git push -u origin main
```

##### …or push an existing repository from the command line

```
git remote add origin https://github.com/HooWC/vue-rabbit.git
git branch -M main
git push -u origin main
```





### 复制你自己的URL

```
git remote add origin https://github.com/HooWC/vue-rabbit.git
```

### 开始使用 （第一次上传到master）

```
git init

git remote add origin https://github.com/HooWC/HOO_LEARNING.git   // 换你自己的url

git status

git add .

git commit -m "up"

git push -u origin master
```

### 初始者需要在CMD输入这些信息，才能上传

```
git config --global user.name "Hoo Weng Chin"

git config --global user.email "wengchinHoo@gmail.com"
```





# `[Branch]` vs code 上传

```
在 Github 创建一个 Branche ， vs code切换分支，上传，最后合并
```

```
git init

git remote add origin https://github.com/HooWC/Netlify-Demo.git   # 换你自己的URL

git status

git add .

git commit -m "first commit"

git branch feature-branch  # 创建名为 feature-branch 的新分支
git checkout feature-branch  # 切换到 feature-branch 分支

# 或者使用下面的命令同时创建并切换到新分支
# git checkout -b feature-branch

git push -u origin feature-branch  # 将代码推送到 feature-branch 分支
```



#### 更新档案  (不需要使用)

`git pull` 是 Git 中的一个命令，用于从远程仓库获取最新的更改

```
git status
git add .
git commit -m "update"
git push

===================

git pull
git push --rebase

git push origin master

强制推送
git push origin master --force

===================
// 遇到 拒绝 时候

git pull --rebase origin master
git push -u origin master
```

```
git checkout -b new-branch //如果你想要的分支还不存在，可以创建并切换到新分支：
git checkout new-branch //切换到你想要的分支（假设目标分支是 new-branch）：
git branch //查看当前的分支和所有分支：
```

#### 在github创建branch后，需要在gitbase手动，保存branch在本地

```
# 查看当前远程分支信息
git fetch

# 查看所有分支，包括远程分支
git branch -a

# 切换到远程分支并创建本地分支
git checkout -b update-branch origin/update-branch

# 进行修改并提交
git status
git add .
git commit -m "update"
git push
```

#### 如果本地已经有了，直接切换就可以了

```
git checkout master
git checkout update-branch
```



## 如何打开 `GitHub Https` 项目

在 Visual Studio Code (VS Code) 中打开 GitHub 仓库的 HTTPS 链接，您可以按照以下步骤操作：

1. **启动 Visual Studio Code**：首先打开 Visual Studio Code。
2. **打开源代码管理器**：在 VS Code 的侧边栏中，您可以找到一个源代码管理器。它通常位于左侧边栏的第三个图标。您可以通过单击该图标或使用快捷键 `Ctrl + Shift + G` 来打开源代码管理器。
3. **克隆存储库**：在源代码管理器中，您将看到一个 "克隆存储库" 的按钮（一个分叉的图标）。点击这个按钮，然后选择 "Clone from GitHub" 选项。
4. **输入仓库 URL**：在弹出的对话框中，输入您想要克隆的 GitHub 仓库的 HTTPS URL。在您的情况下，您可以输入 `https://github.com/HooWC/vue-rabbit.git`。
5. **选择保存位置**：选择您想要将仓库克隆到的本地文件夹。您可以浏览到您想要的位置并选择它。
6. **等待克隆完成**：VS Code 将自动克隆所选仓库到您选择的本地文件夹。您可以在状态栏的右下角看到克隆的进度。
7. **打开存储库**：一旦克隆完成，您可以在源代码管理器中看到新克隆的存储库。您可以展开它以查看其中的文件和文件夹。

通过以上步骤，您就可以在 Visual Studio Code 中打开并克隆 GitHub 仓库的 HTTPS 链接了。





### Git Bash 更换账号

```
git config user.name //查看用户名
git config user.email //查看用户邮件

git config --global user.name ""
git config --global user.email ""
git config --global user.password ""

git config --list // 查看
```

```
git config --global user.name // 查看
git config --global user.email // 查看
```

### Git Bash 更换账号 接下来

```
打开控制面板 -> 用户 -> 管理Window凭据 -> 删除github
然后当你git push的时候，你需要登入，最好选择用code方式来登入。
```

```
git push // 启动登入
```



## `Fork` 上传

```
打开别人的项目，按Fork，修改代码，按Pull Request

再按create pull就可以了
```



