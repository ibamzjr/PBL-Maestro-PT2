# Security Policy

## Educational Scope

PBL Maestro PT2 is an educational release. It has not undergone the controls
required for production commerce, payment processing, or sensitive customer
data. Perform an independent security review before any public deployment.

## Reporting

Please report suspected vulnerabilities privately to the repository owner
through the contact options on the
[ibamzjr GitHub profile](https://github.com/ibamzjr). Do not publish credentials,
personal records, exploit details, or other sensitive material in a public issue.

## Deployment Expectations

- Generate a unique `APP_KEY` and keep `.env` outside version control.
- Use unique, strongly generated administrator credentials.
- Disable debug output and configure HTTPS in non-local environments.
- Restrict uploads by MIME type, size, storage policy, and malware controls.
- Review role middleware, session storage, password reset, and mail settings.
- Apply framework and dependency security updates before deployment.
- Keep databases, logs, sessions, caches, and uploaded media out of Git.
