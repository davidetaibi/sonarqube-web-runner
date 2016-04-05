/*
 * SonarQube Runner - API
 * Copyright (C) 2011-2016 SonarSource SA
 * mailto:contact AT sonarsource DOT com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
package org.sonar.runner.impl;

import org.sonar.runner.cache.Logger;

import java.io.File;
import java.util.List;
import java.util.Properties;

class JarDownloader {
  private final ServerConnection serverConnection;
  private final Logger logger;
  private final Properties props;

  JarDownloader(ServerConnection conn, Logger logger, Properties props) {
    this.serverConnection = conn;
    this.logger = logger;
    this.props = props;
  }

  List<File> download() {
    return new Jars(serverConnection, new JarExtractor(), logger, props).download();
  }
}
