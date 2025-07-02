#!/usr/bin/env bash
host=${1:-https://localhost}
email=${2:-admin@example.com}
good=${3:-12345678}

bad=(wrong1 wrong2 wrong3)
repeat=3

login="$host/api/auth/login"
echo "🔐  Target: $login"

try() {
  curl -sk -w " ↩︎  %{http_code}\n" -X POST "$login" \
    -H "Content-Type: application/json" \
    -d "{\"email\":\"$email\",\"password\":\"$1\"}"
}

i=1
for ((r=0;r<repeat;r++)); do
  for pwd in "${bad[@]}"; do
    echo -n "Attempt $i ($pwd)"
    code=$(try "$pwd")
    [[ $code == *429 ]] && { echo " 🛡️  LIMIT HIT"; exit 0; }
    ((i++))
    sleep 0.3
  done
done
echo "❌  No 429 after $((i-1)) tries"
exit
