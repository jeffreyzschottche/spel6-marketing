# syntax=docker/dockerfile:1

############################
# 1) Build stage
############################
FROM node:22.12.0-bookworm-slim AS build
WORKDIR /app

# Copy lockfiles first for better caching
COPY package.json package-lock.json ./

# Install deps
RUN npm ci

# Copy the rest
COPY . .

# Build Nuxt (SSR output)
RUN npm run build

############################
# 2) Runtime stage
############################
FROM node:22.12.0-bookworm-slim AS runtime
WORKDIR /app

ENV NODE_ENV=production
ENV NITRO_HOST=0.0.0.0
ENV NITRO_PORT=3000

# Copy only the output + minimal package metadata
COPY --from=build /app/.output /app/.output
COPY --from=build /app/package.json /app/package.json
COPY --from=build /app/package-lock.json /app/package-lock.json

# If your runtime needs node_modules (Nuxt/Nitro usually doesn't if output is standalone,
# but safest is to install production deps)
RUN npm ci --omit=dev && npm cache clean --force

EXPOSE 3000

CMD ["node", ".output/server/index.mjs"]
