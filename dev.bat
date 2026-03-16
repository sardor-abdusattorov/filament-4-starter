@echo off
echo Starting dev environment...

docker compose up -d

call npm run dev
