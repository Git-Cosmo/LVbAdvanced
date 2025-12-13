# FPSociety Discord Bot Deployment

This directory contains production deployment configurations for the FPSociety Discord bot.

## Deployment Options

### Option 1: Supervisor (Recommended)

Supervisor is a process control system that makes it easy to manage and monitor long-running processes.

**Setup:**
```bash
# Copy and configure
sudo cp deployment/supervisor-discordbot.conf /etc/supervisor/conf.d/fpsociety-discordbot.conf
sudo nano /etc/supervisor/conf.d/fpsociety-discordbot.conf  # Update paths

# Start
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start fpsociety-discordbot
```

### Option 2: Systemd

**Setup:**
```bash
# Copy and configure
sudo cp deployment/systemd-discordbot.service /etc/systemd/system/fpsociety-discordbot.service
sudo nano /etc/systemd/system/fpsociety-discordbot.service  # Update paths

# Start
sudo systemctl daemon-reload
sudo systemctl enable fpsociety-discordbot
sudo systemctl start fpsociety-discordbot
```

### Option 3: Docker

Already included in `scripts/supervisord.conf`. Just run:
```bash
docker compose up -d
```

## Environment Variables

Required in `.env`:
```env
DISCORD_BOT_TOKEN=your_bot_token_here
DISCORD_GUILD_ID=your_server_id_here
```

See main README for full deployment documentation.
