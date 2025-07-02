#!/usr/bin/env bash

host=${1:-https://localhost}
email=${2:-admin@example.com}
good=${3:-12345678}

bad=(wrong1 wrong2 wrong3)
repeat=3          # 🔁 how many times to loop through bad passwords
wait_secs=60      # ⏳ pause if server responds with 429

login="$host/api/auth/login"
echo "🔐  Target: $login"
echo "📧  Email: $email"
echo

call() {  # $1 = password
  curl -sk -w " ↩︎ %{http_code}\n" -X POST "$login" \
    -H "Content-Type: application/json" \
    -d "{\"email\":\"$email\",\"password\":\"$1\"}"
}

i=1
for ((r=0; r<repeat; r++)); do
  for pwd in "${bad[@]}"; do
    echo "🧪 Attempt $i: password='$pwd'"
    code=$(call "$pwd")
    
    if [[ $code == *429 ]]; then
      echo "🛡️  LIMIT HIT after $i attempts – sleeping $wait_secs s..."
      sleep "$wait_secs"

      echo
      echo "✅ Retrying with correct password..."
      call "$good"
      exit 0
    fi

    ((i++))
    sleep 0.3
  done
done

echo
echo "❌  No rate limit (429) after $((i-1)) attempts"
exit 1
