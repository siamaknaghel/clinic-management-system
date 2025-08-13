# Contributing Guidelines

Thank you for considering contributing to the **Laravel Filament Starter Kit**!

This starter kit is designed to be the foundation for all future projects. Your contributions help make it more robust, secure, and maintainable.

---

## 🛠 How to Contribute

1. Fork the repository.
2. Create a new branch:  
   ```bash
   git checkout -b feature/your-feature
   ```
3. Commit your changes with a meaningful message:  
   ```bash
   git commit -m "feat: add user export action"
   ```
4. Push to the branch:  
   ```bash
   git push origin feature/your-feature
   ```
5. Open a Pull Request.

---

## 📏 Commit Message Format

We use [Conventional Commits](https://www.conventionalcommits.org/):
 ```bash
  <type>: <description>

    [optional body]

    [optional footer(s)]
```

   
### Examples:
- `feat: add export button to bookings`
- `fix: prevent crash when role is null`
- `docs: update README with Sail instructions`
- `refactor: improve permission seeder logic`
- `test: add policy test for staff access`

### Allowed Types:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Formatting, no logic change
- `refactor`: Code restructuring
- `test`: Adding or fixing tests
- `chore`: Build or tooling changes
- `perf`: Performance improvement
- `ci`: CI/CD configuration

---

## 🧪 Testing

Always run tests before submitting a PR:

```bash
php artisan test
```

If you added new features, ensure they are covered with unit or feature tests.

---

## 📁 Code Style

- Follow Laravel's coding standards.
- Use PSR-4 autoloading.
- Keep folder structure consistent.
- Run Pint for formatting:
  ```bash
  php artisan pint
  ```

---

## 🤔 Questions?

If you're unsure whether a change fits the project, open a **Discussion** or an **Issue** first.

We appreciate your effort and look forward to your contributions!
